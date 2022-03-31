/**
 * Create url at server side.
 * Создание URL-адреса на стороне сервера и передача его на клиент через callback-функцию.
 * @param route - module/controller/action
 * @param params - parameters
 * @param callback - callback function
 */
function createUrl(route, params, callback) {
    if (arguments[2]===undefined) { // Если передано только 2 аргумента
        callback = params;
        params = {};
    }

    $.post('/ajax/createurl', {route:route, params:params}, function(response) {
        callback(response);
    });
}
