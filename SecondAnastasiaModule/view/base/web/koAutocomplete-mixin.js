define([], function () {
    'use strict';
    return function (Target) {
        return Target.extend({
            initialize: function () {
                this._super();
                this.minChars = 5;
            }
        });
    }
});
