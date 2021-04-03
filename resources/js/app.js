import Notify from './components/Notify';
window.notify = Notify;

// Alias functions for better readability and simpler selection
window.$ = function(sel, context) {
    try {
        return !context ? document.querySelector(sel) : context.querySelector(sel);
    } catch (e) {
        return undefined;
    }
};
window.$$ = function(sel, context) {
    try {
        return !context ? document.querySelectorAll(sel) : context.querySelectorAll(sel);
    } catch (e) {
        return undefined;
    }
};