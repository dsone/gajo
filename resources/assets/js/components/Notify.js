export default function Notify(title, message, className) {
    let timer = undefined;
    // notification container, holding all elements
    let tile = document.createElement('div');
        tile.classList.add('notification', 'is-' + className, 'notification-item', 'quickly-animated', 'fadeInDown');

    // The button to prematurely close the notification
    let btn = document.createElement('button');
        btn.classList.add('delete');
        btn.addEventListener('click', function(e) {
            if (timer !== undefined) {
                clearTimeout(timer);
            }
            tile.classList.add('fadeOutRight');
            setTimeout(function() {
                tile.remove();
            }, 750);
        });
    tile.appendChild(btn);

    // Title for the notification
    let header = document.createElement('h3');
        header.classList.add('n-subtitle');
        header.innerText = title;
    tile.appendChild(header);

    // Text node, aka message
    let text = document.createElement('div');
        text.classList.add('n-text');
        text.innerHTML = message;
    tile.appendChild(text);

    // Add it to global notification container
    document.querySelector('.notifications').prepend(tile);

    // start timer to close automatically after 5s
    timer = setTimeout(function() {
        btn.click();
    }, 3000);
};