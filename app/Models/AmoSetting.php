<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AmoSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',

        'minimum_duration',
        'recording',

        'roistat',

        'field',
        'value',
    ];

    /**
     * Default.
     *
     * @var array
     */
    protected $fillable_default = [
        'minimum_duration' => 0,
        'recording' => 3,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function settingable()
    {
        return $this->morphTo();
    }

    /**
     * @param \App\Models\Amo $amo
     * @param \App\Models\Amo|\App\Models\AmoManager $model
     * @param array $errors
     *
     * @return array
     */
    public static function viewFieldsData(Amo $amo, $model, $errors = [])
    {
        $errors = collect($errors);
        $id = $model instanceof Amo ? false : $model->id;

        $id_postfix = ($id ? '_'.$id : '');
        $name_prefix = 'settings'.($id ? '['.$id.']' : '');
        $value_prefix = 'settings.'.($id ? $id.'.' : '');

        $field_views = [];

        $fields = [
            'status' => [
                'view' => 'common.input.select',
                'label' => __('Leads Status'),
                'placeholder' => __('Choice Leads Status'),
                'required' => true,
                'help' => 'Leads status after processing. May be individual.',
            ],

            'minimum_duration' => [
                'view' => 'common.input.number',
                'label' => __('Minimum Duration'),
                'default' => 0,
                'required' => true,
                'step' => 5,
            ],
            'recording' => [
                'view' => 'common.input.select',
                'label' => __('Recording'),
                'placeholder' => __('Choice Leads Status'),
                'required' => true,
                'options' => ['0' => 'Не записывать', '1' => 'Входящие', '2' => 'Исходящие', '3' => 'Все звонки'],
                'default' => 3,
                'without_default' => true,
            ],

            'roistat' => [
                'view' => 'common.input.select',
                'label' => __('Roistat Field'),
                'placeholder' => __('Choice Roistat Field'),
                'help' => 'Setup WEBHOOK to URL'.($amo->id ? ': '.url(route('api.amo.roistat.webhook', $amo)) : ''),
            ],

            'field' => [
                'view' => 'common.input.select',
                'label' => __('Custom Field'),
                'placeholder' => __('Choice Custom Field'),
                'required' => true,
                'trigger' => 'change',
            ],
            'value' => [
                'view' => 'common.input.select',
                'label' => __('Custom Value'),
                'placeholder' => __('Custom Value'),
                'required' => true,
            ],
        ];

        foreach ($fields as $field => $data) {
            $field_views[] = [
                    'id' => $field.$id_postfix,
                    'name' => $name_prefix.'['.$field.']',
                    'value' => old($value_prefix.$field,
                        optional($model->settings)->$field ?? optional($amo->settings)->$field ?? $data['default'] ?? ''),
                    'class' => implode(' ', [
                        $errors->has('status') ? 'is-invalid' : '',
                        kebab_case('js'.studly_case($field)),
                    ]),
                ] + $data;
        }

        return $field_views;
    }
}
