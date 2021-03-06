'use strict';

(function() {
    var doAjaxRequest = function(url, queryParams, options) {
        var xhr = new XMLHttpRequest();
        var method = options.method ? options.method : 'GET';
        var generateUrl = function(url, method, queryParams) {
            if (method !== 'GET') {
                return url;
            }

            var queryParamsArray = [];
            for (var key in queryParams) {
                queryParamsArray.push(key + '=' + encodeURIComponent(queryParams[key]));
            }

            return url + (url.indexOf('?') > 0 ? '&' : '?') + queryParamsArray.join('&');
        };
        xhr.open(method, generateUrl(url, method, queryParams), true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onreadystatechange = function() {
            if (xhr.readyState != 4) {
                return;
            }

            if (xhr.status != 200) {
                if (options.onError) {
                    options.onError(xhr.status, xhr.statusText);
                }
            } else {
                if (options.onSuccess) {
                    options.onSuccess(xhr.responseText);
                }
            }
        }
        xhr.send();
    };

    var generateUrlForm = function(onSuccess, onError) {
        this.form = document.getElementById('js-generate-url-form');
        this.isInProgress = false;
        this.init = function() {
            var self = this;

            self.form.addEventListener('submit', function(event) {
                event.preventDefault();
                var shortUrlInput = document.getElementById('js-short-url');
                shortUrlInput.value = '';
                shortUrlInput.style.display = '';

                if (self.isInProgress) {
                    return false;
                }

                self.isInProgress = true;
                doAjaxRequest(
                    self.form.action, {
                        url: document.getElementById('js-input-url').value
                    }, {
                        onSuccess: function(data) {
                            self.isInProgress = false;

                            if (onSuccess) {
                                onSuccess(data);
                            }
                        },
                        onError: function(code, text) {
                            self.isInProgress = false;

                            if (onError) {
                                onError(code, text);
                            }
                        },
                    }
                );
            });
        };
    };

    var form = new generateUrlForm(
        function(data) {
            data = JSON.parse(data);

            if (data.success) {
                var shortUrlInput = document.getElementById('js-short-url');
                shortUrlInput.value = data.short_url;
                shortUrlInput.style.display = 'block';
                shortUrlInput.focus();
                try {
                    shortUrlInput.select();
                } catch (e) {
                    shortUrlInput.setSelectionRange(0, shortUrlInput.value.length);
                }
            } else {
                alert(data.error);
            }
        },
        function(code, text) {
            alert('something went wrong: ' + text);
        }
    );
    form.init();
})();