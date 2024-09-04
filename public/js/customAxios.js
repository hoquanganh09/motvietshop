async function ajax(url = '', method = 'get', data = {}, callback = undefined, error = undefined) {
    method = method.toLowerCase();

    if (method === 'get' && Object.values(data).length > 0) {
        url = `${url}?${new URLSearchParams(data).toString()}`;
        data = {};
    }

    try {
        const response = await axios[method](url, data);
        
        callback && callback(response);
    }
    catch (e) {
        console.log(e);
        
        error && error(e);
    }
}

function loadView(url, view = undefined, isJquery = true) {
    if (view == undefined) {
        view = $('#view_ajax');
    }
    ajax(url, 'get', {}, function (e) {
        if (isJquery) {
            view.html(e.data);
        }
        else {
            view.innerHTML = e.data;
        }
    });
}

function appendView(url, view = undefined, isJquery = true) {
    if (view == undefined) {
        view = $('#view_ajax');
    }
    ajax(url, 'get', {}, function (e) {
        if (isJquery) {
            view.append(e.data);
        }
        else {
            view.innerHTML += e.data;
        }
    });
}