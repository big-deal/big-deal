<?php

namespace App\Jobs\Beeline;

use App\Models\Beeline;
use Illuminate\Bus\Queueable;
use Ixudra\Curl\Facades\Curl;
use App\Events\Beeline\Subscribed;
use App\Events\Beeline\Subscribing;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class Subscribe implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var bool
     */
    protected static $first_call;

    /**
     * @var bool
     */
    protected $from_event = false;

    /**
     * @var \App\Models\Beeline
     */
    protected $beeline;

    /**
     * Create a new job instance.
     *
     * @param \App\Models\Beeline $beeline
     * @param bool $from_event
     *
     * @return void
     */
    public function __construct(Beeline $beeline, bool $from_event = false)
    {
        $this->beeline = $beeline;
        $this->from_event = $from_event;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (! $this->mustHandled()) {
            return;
        }

        event(new Subscribing($this->beeline));

        if ($this->beeline->subscribe_id) {
            $response = Curl::to('https://cloudpbx.beeline.ru/apis/portal/subscription')
                ->withHeader('X-MPBX-API-AUTH-TOKEN: '.$this->beeline->token)
                ->withContentType('application/json')
                ->withData([
                    'subscriptionId' => $this->beeline->subscribe_id,
                ])
                ->asJson()
                ->get();

            if (! isset($response->subscriptionId, $response->expires, $response->url)) {
                $this->newSubscription();
            }
        } else {
            $this->newSubscription();
        }

        event(new Subscribed($this->beeline));
    }

    /**
     * Subscribe.
     */
    protected function newSubscription()
    {
        $response = Curl::to('https://cloudpbx.beeline.ru/apis/portal/subscription')
            ->withHeader('X-MPBX-API-AUTH-TOKEN: '.$this->beeline->token)
            ->withContentType('application/json')
            ->withData([
                'expires' => 60 * 60 * 24 * 365,
                'subscriptionType' => 'ADVANCED_CALL',
                'url' => route('api.beeline.webhook', $this->beeline),
            ])
            ->asJson()
            ->put();

        if (isset($response->subscriptionId, $response->expires)) {
            $this->beeline->update([
                'subscribe_id' => $response->subscriptionId,
            ]);
        }
    }

    /**
     * @return bool
     */
    protected function mustHandled()
    {
        return ! $this->from_event || (static::$first_call = ! static::$first_call);
    }
}
