function attachHandler(el, evtname, fn) {
    if (el.addEventListener) {
        el.addEventListener(evtname, fn.bind(el), false);
    }
    else if (el.attachEvent) {
        el.attachEvent('on' + evtname, fn.bind(el));
    }
};
