define(['jquery', 'uiComponent'], function ($, Component) {
    return Component.extend({
        defaults: {
            hours: 0,
            minutes: 0,
            seconds: 0,
            timer: null,
        },
        initObservable: function () {
            this._super();
            this.observe(['seconds', 'minutes', 'hours', 'timer']);
            return this;
        },
        initialize: function () {
            this._super();
        },
        handleStart: function () {
            if (!this.timer()) {
                this.timer(setInterval(() => {
                    var seconds = this.seconds();
                    var minutes = this.minutes();
                    var hours = this.hours();

                    if (minutes === 59) {
                        this.minutes(0);
                        this.hours(hours + 1);
                    } else {
                        if (seconds === 59) {
                            this.seconds(0);
                            this.minutes(minutes + 1);
                        } else {
                            this.seconds(seconds + 1);
                        }
                    }
                }, 1000));
            }

        },
        handleStop: function () {
            clearInterval(this.timer());
            this.timer(null);
            this.seconds(0);
            this.minutes(0);
            this.hours(0);
        },
        handlePause: function () {
            clearInterval(this.timer());
            this.timer(null);
        },

    });
});
