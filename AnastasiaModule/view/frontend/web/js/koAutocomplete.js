define(['jquery', 'uiComponent', 'mage/url'], function ($, Component, urlBuilder) {
    return Component.extend({
        defaults: {
            searchText: '',
            minChars: 3,
            searchResult: [],
            searchUrl: urlBuilder.build('anastasia/autocomplete/autocomplete'),
            isFocused: false,
        },
        initObservable: function () {
            this._super();
            this.observe(['searchText', 'searchResult', 'isFocused']);
            return this;
        },
        initialize: function () {
            this._super();
            this.searchText.subscribe(this.handleAutocomplete.bind(this));
        },
        handleAutocomplete: function (searchValue) {
            this.isFocused(true);
            searchValue.length < this.minChars ?
                this.searchResult([]) : $.getJSON(this.searchUrl, {
                    q: searchValue
                }, function (data) {
                    if (data.length) {
                        this.searchResult(data);
                        $('body').on('click', '.css-li-autocomplete', this.processAutocomplete.bind(this));
                    } else {
                        this.searchResult([]);
                    }
                }.bind(this));
        },

        processAutocomplete: function (event) {
            var elLi = event.currentTarget;
            var valueElLi = $(elLi).find("span[data-bind='text: sku']").text();
            this.searchText(valueElLi);
            this.isFocused(false);
        },
    });
});
