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
                document.getElementById('js-short-url').innerHTML = '';

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
                var placeForShortUrl = document.getElementById('js-short-url');
                var link = document.createElement('a');
                link.setAttribute('href', data.short_url);
                link.innerHTML = data.short_url;
                link.target = '_blank';
                placeForShortUrl.appendChild(link);
            } else {
                alert(data.message);
            }
        },
        function(code, text) {
            alert('something went wrong: ' + text);
        }
    );
    form.init();
})();