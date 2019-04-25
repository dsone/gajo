export default function Options(config = {}) {
    if (!(this instanceof Options)) {
        return new Options(config);
    }

    this.data = {
        btnRSSChange: config.btnRSSChange,
        check_hide_released: config.check_hide_released,
        check_hide_tba: config.check_hide_tba,
        checkbox_colorblind_mode: config.checkbox_colorblind_mode,
        checkbox_private_profile: config.checkbox_private_profile,
        rss_input: config.rss_input,
        rss_link: config.rss_link,
        user_types: config.user_types,  // The user types object to create the list from
        container_types: config.container_types,    // the container holding all type elements
        btn_add_type: config.btn_add_type,

        // Interactive events use these callbacks
        typeChangeCB: config.typeChangeCB,
        typeMoveCB: config.typeMoveCB,
        typeRemoveCB: config.typeRemoveCB,
        typeAddCB: config.typeAddCB,

        ajaxInProgress: false,
    };

    // optional event listener for any element inside config
    // events: { 'click': { 'item1': function() {} }, 'hover': { 'item2': function() {} } }
    if (typeof(config.events) !== 'undefined') {
        for (let event in config.events) {
            for (let item in config.events[event]) {
                if (typeof(item) !== 'undefined') {
                    document.querySelector(item).addEventListener(event, config.events[event][item]);
                }
            }
        }
    }

    this.data.btn_add_type.addEventListener('click', (e) => {
        this.data.ajaxInProgress = true;
        this.data.typeAddCB(e, (render) => {
            this.data.ajaxInProgress = false;
            if (!render) {
                this.renderTypes();
            }
        });
    });

    this.renderTypes();
}

/**
 * Gets the state of a private profile.
 * 
 * @return   {boolean}       True for private, false for public
 */
Options.prototype.isPrivateProfile = function() {
    return this.data.checkbox_private_profile.checked;
};
/**
 * Gets whether colorblind mode is on or not.
 * 
 * @return   {boolean}       True on, false for off
 */
Options.prototype.isColorBlindMode = function() {
    return this.data.checkbox_colorblind_mode.checked;
};
/**
 * Gets whether released entries are hidden or not.
 * 
 * @return   {boolean}       True means yes, false no
 */
Options.prototype.isHiddenReleased = function() {
    return this.data.check_hide_released.checked;
};
/**
 * Gets whether TBA entries are hidden or not.
 * 
 * @return   {boolean}       True means yes, false no
 */
Options.prototype.isHiddenTBA = function() {
    return this.data.check_hide_tba.checked;
};

/**
 * Sets the RSS Input value.
 * 
 * @param   {string}        rss     The new rss lin to display
 */
Options.prototype.setRSS = function(rss) {
    this.data.rss_input.value = rss;
    this.data.rss_link.href =  this.data.rss_link.getAttribute('data-route') + rss;
};

/**
 * Returns the options object to send to the server.
 * 
 * @return   {JSON}       A JSON object representation ob the options
 */
Options.prototype.getOptions = function() {
    return {
        colorblind_mode: this.isColorBlindMode(),
        private_profile: this.isPrivateProfile(),
        list_hide_released: this.isHiddenReleased(),
        list_hide_tba: this.isHiddenTBA()
    };
};



/**
 * Takes an array with HTML information and creates respective elements for it.
 * 
 * @param   {Array}         _arr        A specially formatted array of HTML information
 * @return  {HTMLElement}               The HTML structur created from the input array
 */
Options.prototype.createHTML = function(_arr) {
    let el = undefined;
    for (let i = 0; i < _arr.length; ++i) {
        let _tel;
        // sub array, do it recursively
        if (Array.isArray(_arr[i])) {
            _tel = this.createHTML(_arr[i]);
        } else if (typeof _arr[i] === 'object') { // beware of null, shouldn't happen here, but still
            let _attr = Object.keys(_arr[i]); // in key '_': the element type to create
            _attr.sort();  // let's put _ and __ to the front
            // if there's no _ at the front, the element to create is unknown - skip
            if (_attr[0] !== '_') { continue; }

            _tel = document.createElement(_arr[i][_attr[0]]);
            let start = _attr.length > 1 && _attr[1] === '__' ? 2 : 1;
            if (start > 1) {
                let svg = SVG(_arr[i][_attr[1]]);
                if (svg === null) {
                    _tel.innerHTML = _arr[i][_attr[1]];
                } else {
                    if (_attr[2] === '___') {
                        start = 3;
                        $('.svg-icon', svg).classList.add(_arr[i][_attr[2]]);
                    }
                    _tel.appendChild(svg);
                }
            }  // __ in attr detected -> innerHTML, treat special
            // loop through the rest of the attributes
            for (let j = start; j < _attr.length; ++j) {
                _tel.setAttribute(_attr[j], _arr[i][_attr[j]]);
            }
        // just a string identifying the element to create
        } else {
            _tel = document.createElement(_arr[i]);
        }
        // if the first entry in _arr is another array,
        // the returned value of the recursive call would be in _tel and el still undef,
        // meaning, we can't check for i === 0
        if (el === undefined) {
            el = _tel;
        } else {
            el.appendChild(_tel);
        }
    }
    return el;
};

Options.prototype.prepareHTMLArray = function () {
    let html = [
        { '_': 'div' }  // parent container for all "child" type-items
    ];

    this.data.user_types.forEach((element, i) => {
        let options = [
            { '_': 'span', 'class': 'select', 'data-key': 'display' },
            [
                { '_': 'select', 'class': 'js-type-display js-type-changeable', 'data-key': 'display' },
                { '_': 'option', '__': 'List Display', 'value': 1 },
                { '_': 'option', '__': 'Card Display', 'value': 2 },  
            ]
        ];
        if (element.display == 1) {
            options[1][1].selected = 'selected';
        } else {
            options[1][2].selected = 'selected';
        }
        
        html.push(
            [
                { '_': 'div', 'class': 'field has-addons type-item', 'data-id': element.id, 'data-sort': element.sort },
                [
                    { '_': 'p', 'class': 'control'},
                    { '_': 'input', 'class': 'input js-type-changeable', 'type': 'text', 'value': element.name, 'data-key': 'name' }
                ],
                [
                    { '_': 'p', 'class': 'control'},
                    { '_': 'input', 'class': 'input js-type-changeable', 'type': 'text', 'value': element.ident_1, 'data-key': 'ident_1' }
                ],
                [
                    { '_': 'p', 'class': 'control'},
                    { '_': 'input', 'class': 'input js-type-changeable', 'type': 'text', 'value': element.ident_2, 'data-key': 'ident_2' }
                ],
                [
                    { '_': 'p', 'class': 'control'},
                    options
                ],
                [
                    { '_': 'p', 'class': 'control'},
                    {
                        '_': 'a', '__': '{svg-angle-up}',
                        'class': 'button js-move' + (i === 0 ? ' disabled' : ''),
                        'data-interact': 'up'
                    },
                ],
                [
                    { '_': 'p', 'class': 'control'},
                    {
                        '_': 'a', '__': '{svg-angle-down}',
                        'class': 'button js-move' + (i === this.data.user_types.length-1 ? ' disabled' : ''),
                        'data-interact': 'down'
                    },
                ],
                [
                    { '_': 'p', 'class': 'control'},
                    {
                        '_': 'a', '__': '{svg-trash-alt}', '___': 'icon-sm',
                        'class': 'button is-danger js-remove',
                    }
                ],
            ]
        );
    });

    if (html.length === 1) {
        html[0]['__'] = "You have none.";
    }

    return html;
};

Options.prototype.bindEvents = function() {
    // Input/select changes
    this.data.container_types.querySelectorAll('.js-type-changeable').forEach(
        (element, i) => {
            element.addEventListener('change', () => {
                if (this.data.ajaxInProgress) { return; }
                this.data.ajaxInProgress = true;

                this.data.typeChangeCB(element, () => {
                    this.data.ajaxInProgress = false;
                    this.renderTypes();
                });
            });
        }
    );

    // Move up/down
    this.data.container_types.querySelectorAll('.js-move:not(.disabled)').forEach(
        (element, i) => {
            element.addEventListener('click', () => {
                if (this.data.ajaxInProgress) { return; }
                this.data.ajaxInProgress = true;

                this.data.typeMoveCB(element, () => {
                    this.data.ajaxInProgress = false;
                    this.renderTypes();
                });
            });
        }
    );

    // Remove Buttons
    this.data.container_types.querySelectorAll('.js-remove').forEach(
        (element, i) => {
            element.addEventListener('click', () => {
                if (this.data.ajaxInProgress) { return; }
                this.data.ajaxInProgress = true;

                this.data.typeRemoveCB(element, () => {
                    this.data.ajaxInProgress = false;
                    this.renderTypes();
                });
            });
        }
    );    
};

Options.prototype.renderTypes = function() {
    let html = this.createHTML(this.prepareHTMLArray());
    this.data.container_types.innerHTML = '';
    this.data.container_types.appendChild(html);
    this.bindEvents();
};