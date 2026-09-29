
var ADMIN_API_BASE = window.ADMIN_API_BASE || "/admin";

var API_ROUTES = {
};

var api = {
  request: function (action, entity, payload) {
    payload = payload || {};

    var url = API_ROUTES[entity];
    if (entity === "login") url = window.ADMIN_LOGIN_URL || "/login-admin-aisybina-export";
    if (entity === "logout") url = window.ADMIN_LOGOUT_URL || "/logout";
    var method = "GET";
    if (action === "create") method = "POST";
    if (action === "update") method = "PUT";
    if (action === "delete") method = "DELETE";
    var ajaxOptions = {
      url: url,
      method: method,
      dataType: "json",
      headers: {
        "Accept": "application/json"
      }
    };
    ajaxOptions.data = payload.data || {};
    ajaxOptions.contentType = "application/json; charset=UTF-8";
    ajaxOptions.processData = false;
    ajaxOptions.data = JSON.stringify(ajaxOptions.data);
    return $.ajax(ajaxOptions).fail(function (xhr) {
      var error = normalizeError(xhr);
      xhr.message = error.message;
    });
  }
};
$.ajaxSetup({
  headers: {
    "X-CSRF-TOKEN": $("meta[name=csrf-token]").attr("content") || ""
  },
  xhrFields: {
    withCredentials: true
  }
});
