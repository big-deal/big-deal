(($) => {
    $.fn.amoSettings = function (options) {
        let defaults = {
                "auth": false,
            },
            settings = $.extend(defaults, options),
            self = this,
            fields = {};

        self.fieldsHandler = (data) => {
            if (data.response) {
                fields = data.response.fields;
                /**
                 * Status
                 */
                do {
                    let $status = $(".js-status", self);

                    $status
                        .find("option:gt(0), optgroup")
                        .remove();

                    $.each(data.response.statuses, (index, item) => {
                        let $optgroup = $("<optgroup>")
                            .attr("label", item.name);

                        $.each(item.statuses, (index, status) => {
                            $optgroup
                                .append(
                                    $("<option>")
                                        .attr("value", status.id)
                                        .text(status.name)
                                );
                        });

                        $status
                            .append(
                                $optgroup
                            );
                    });
                } while (false);

                /**
                 * Roistat
                 */
                do {
                    let $roistat = $(".js-roistat", self);

                    $roistat
                        .find("option:gt(0)")
                        .remove();

                    $.each(data.response.fields, (index, item) => {
                        $roistat
                            .append(
                                $("<option>")
                                    .attr("value", item.id)
                                    .text(item.name)
                            );
                    });
                } while (false);

                /**
                 * Field
                 */
                do {
                    let $field = $(".js-field", self);

                    $field
                        .find("option:gt(0)")
                        .remove();

                    $.each(data.response.fields, (index, item) => {
                        $field
                            .append(
                                $("<option>")
                                    .attr("value", item.id)
                                    .text(item.name)
                            );
                    });
                } while (false);
            } else if (data.error) {
                self.fieldsErrorHandler(data.error);
            }
        };
        self.fieldsErrorHandler = (data) => {};
        self.fieldsAlwaysHandler = () => {
            $(".js-form-lock")
                .add(self)
                .removeAttr("disabled");

        };
        self.auth = function () {
            let $form_lock = $(".js-form-lock");

            $form_lock
                .attr("disabled", "disabled");

            $("#domain, #login, #hash")
                .closest(".form-group")
                .removeClass("has-error");

            let $query = {};

            $(".js-auth")
                .each((index, emelent) => {
                    let $el = $(emelent);
                    $query[$el.attr("name")] = $el.val();
                });

            for (let index in $query) {
                if (!$query[index]) {
                    $form_lock
                        .removeAttr("disabled");
                    return;
                }
            }

            $.post(settings.url, $query)
                .done(self.fieldsHandler)
                .fail(self.fieldsErrorHandler)
                .always(self.fieldsAlwaysHandler);
        };

        if (settings.auth) {
            $(".js-auth")
                .on("change", self.auth)
                .first()
                .trigger("change");
        } else {
            $.post(settings.url)
                .done(self.fieldsHandler)
                .fail(self.fieldsErrorHandler)
                .always(self.fieldsAlwaysHandler);
        }

        $(".js-field", self)
            .on("change", (event) => {
                let $el = $(event.currentTarget),
                    $val = $('.js-value', self);

                if ($el.val()) {
                    $.each(fields, (index, item) => {
                        if (item.id === $el.val() && item.enums) {
                            $val
                                .removeAttr("disabled");

                            $.each(item.enums, (id, name) => {
                                $val
                                    .append(
                                        $('<option>')
                                            .attr('value', id)
                                            .text(name)
                                    );
                            });
                        }
                    });
                } else {
                    $val
                        .attr("disabled", "disabled")
                        .find('option:gt(0)')
                        .remove();
                }
            })
            .trigger("change");

        setTimeout(((_self, _fields) => {
            let self = _self,
                $fields = _fields;

            return () => {
                for (let $key = 0, $field; $field = $fields[$key]; $key++) {
                    let $el = $("#" + $field.id);

                    $el.val($field.value);
                    if ($field.trigger) {
                        $el.trigger($field.trigger);
                    }
                }

                self
                    .removeAttr("disabled");
            }
        })(self, settings.fields), 1e3);

        return self;
    };
})(jQuery);
