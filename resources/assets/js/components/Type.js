import Entry from './Entry';

export default function Type(config = {}) {
    if (!(this instanceof Type)) {
        return new Type(config);
    }

    this.data = {
        // object data
        id: config.id,
        name: config.name,
        ident_1: config.ident_1,
        ident_2: config.ident_2,
        sort: config.sort,
        display: config.display,

        // runtime data
        entries: [],
        mapEntryId2Index: {},
        dirtyHTML: true,  // when true, the HTML needs to be rendered (due to change or init, etc)
        sortedList: [],   // based on config.sortBy asorted IDs of the entries inside this,
                          // whenever dealing with the entries property go over this list, only sorting the ids in this new var decouples shuffling of objects
    };

    this.config = {
        sortBy: 'ident_1',  // default fallback
        sortOrderAsc: true, // dbl click toggles between asc - desc
    };
};

/**
 * Adds a new entry to this type.
 * 
 * @param   {JSON}  config      The config object for the new Entry
 */
Type.prototype.addEntry = function(config) {
    config.belongsTo = this;
    this.data.entries.push(new Entry(config));
    this.data.mapEntryId2Index[config.id] = this.data.entries.length-1;
    this.data.sortedList.push(config.id);
    
    this.sort();  // sets dirty property
}

/**
 * Returns an entry by ID.
 * 
 * @return {object}     The Entry object, undefined if not available
 */
Type.prototype.getEntry = function(id) {
    if (typeof(this.data.mapEntryId2Index[id]) !== 'undefined') {
        return this.data.entries[this.data.mapEntryId2Index[id]];
    }

    return undefined;
};

/**
 * Deletes an entry by ID.
 * 
 * @return {Entry}    Returns the removed Entry object
 */
Type.prototype.deleteEntry = function(id) {
    if (typeof(this.data.mapEntryId2Index[id]) === 'undefined') {
        return false;
    }

    this.setDirty();
    // Removing from entries array means that the map and sortedList arrays need to be synced
    let removed = this.data.entries.splice(this.data.mapEntryId2Index[id], 1);

    let _newMap = {};
    this.data.sortedList.length = 0;
    for (let i = 0; i < this.data.entries.length; ++i) {
        _newMap[this.data.entries[i].getId()] = i;
        this.data.sortedList.push(this.data.entries[i].getId());
    }
    this.data.mapEntryId2Index = Object.assign({}, _newMap);

    this.sort();  // resort
    return removed;
};

/**
 * Gets the id of this Type. 
 * 
 * @return   {integer}    The id of this Type
 */
Type.prototype.getId = function() {
    return this.data.id;
};

/**
 * Sets the name for this Type. 
 * Name is the heading for this Type.
 * 
 * @param   {String}    _new        The new name for this Type
 */
Type.prototype.setName = function(_new) {
    this.setDirty();

    this.data.name = _new;
};

/**
 * Gets the name of this Type. 
 * Name is the heading of this Type.
 * 
 * @return   {String}    The name of this Type
 */
Type.prototype.getName = function() {
    return this.data.name;
};

/**
 * Sets the ident_1 attribute for this Type. 
 * 
 * @param   {String}    _new        The new ident_1 for this Type
 */
Type.prototype.setIdent1 = function(_new) {
    this.setDirty();

    this.data.ident_1 = _new;
};

/**
 * Gets the ident_1 of this Type. 
 * 
 * @return   {String}    The ident_1 of this Type
 */
Type.prototype.getIdent1 = function() {
    return this.data.ident_1;
};

/**
 * Sets the ident_2 for this Type. 
 * 
 * @param   {String}    _new        The new ident_2 for this Type
 */
Type.prototype.setIdent2 = function(_new) {
    this.setDirty();

    this.data.ident_2 = _new;
};

/**
 * Gets the ident_2 of this Type. 
 * 
 * @return   {String}    The ident_2 of this Type
 */
Type.prototype.getIdent2 = function() {
    return this.data.ident_2;
};

/**
 * Sets the sort position for this Type. 
 * If there are multiple Types displayed, they are sorted by this property.
 * This has no direct influence on the `dirtyHTML` property, hence it doesn't change that state.
 * 
 * @param   {integer}    _new        The new sort position for this Type
 */
Type.prototype.setSort = function(_new) {
    this.setDirty();

    this.data.sort = _new;
};

/**
 * Gets the sort position of this Type. 
 * 
 * @return   {integer}    The sort position of this Type
 */
Type.prototype.getSort = function() {
    return this.data.sort;
};

/**
 * Sets the display type for this Type. 
 * Currently there are two: table(1) and card(2).
 * 
 * @param   {integer}    _new        The new display type for this Type
 */
Type.prototype.setDisplayType = function(_new) {
    this.setDirty();

    this.data.display = _new;
};

/**
 * Gets the display type for this Type. 
 * Currently there are two: table(1) and card(2).
 * 
 * @param   {integer}       The display type for this Type
 */
Type.prototype.getDisplayType = function() {
    return this.data.display;
};

/**
 * Returns the state of the HTML belonging to this Type.
 * If `true` then this Type's HTML needs to be rendered due to changes.
 * When `renderHTML()` is called without a target for the HMTL to put into,
 * dirtyHTML will always be true.
 * 
 * @returns     {boolean}       True when Type or any Entries inside it were changed
 */
Type.prototype.isDirty = function() {
    return this.data.dirtyHTML;
};

/**
 * Sets this Type as dirty.
 * 
 * @returns     {boolean}       True when Type or any Entries inside it were changed
 */
Type.prototype.setDirty = function() {
    this.data.dirtyHTML = true;
};

/**
 * Creates an array with HTML structure for the Table display.
 * Uses the internal information on this Type object for entries.
 * 
 * @return  {Array}     An Array of HTML structure that can be build inside `createHTML()`
 */
Type.prototype.prepareTableHTMLArray = function() {
    let mapVisibility = {
        'v-is-hidden': 'Only visible on the website when logged in',
        'v-is-private': 'Visible on the website when logged in and RSS',
        'v-is-public': 'Visible everywhere'
    };

    let tbody = [
        { '_': 'div', 'class': 'table-item table--' + this.data.name },
        [
            { '_': 'ul', 'class': 'responsive-table' },
            [
                { '_': 'li', 'class': 'table-header' },
                {
                    '_': 'div', '__': this.data.ident_1,
                    'class': 'col col-3 js-sortable' + (this.config.sortBy === 'ident_1' ? ' sort-active' : ''),
                    'data-property': 'ident_1', 'data-type': this.data.id
                },
                {
                    '_': 'div', '__': this.data.ident_2,
                    'class': 'col col-3 js-sortable' + (this.config.sortBy === 'ident_2' ? ' sort-active' : ''),
                    'data-property': 'ident_2', 'data-type': this.data.id
                },
                {
                    '_': 'div', '__': 'Release',
                    'class': 'col col-2 js-sortable' + (this.config.sortBy === 'release_at' ? ' sort-active' : ''),
                    'data-property': 'release_at', 'data-type': this.data.id
                }
            ]
        ]
    ];
    if (isUser) {
        tbody[1][1].push({ '_': 'div', '__': '&nbsp;', 'class': 'col col-2' });
    }

    for (let j = 0; j < this.data.sortedList.length; ++j) {
        let entry = this.data.entries[this.data.mapEntryId2Index[this.data.sortedList[j]]];

        let _date = entry.getReleaseAt() === null ? 'TBA' : new Date(entry.getReleaseAt());
        let dateHumanReadable = _date;
        if (_date !== 'TBA') {
            dateHumanReadable = _date.toGMTString();
            let res = dateHumanReadable.match(new RegExp(".+?,.+? [0-9]{4}"));
            dateHumanReadable = res[0];
        }

        let is_released = +_date < +new Date;
        let is_soon = +_date < ( (+new Date) + 604800000 );         // a week
        let is_immediate = +_date < ( (+new Date) + 172800000 );    // 48 hours
        let date_class = is_released ? ' is-released' : (is_immediate ? ' is-immediate' : ( is_soon ? ' is-soon' : '' ) );
        let visibility_class =  entry.getVisibility() == 1 ? ' v-is-hidden' : ( entry.getVisibility() == 2 ? ' v-is-private' : ' v-is-public' );

        let tr = [
            { '_': 'li', 'class': 'table-row' + date_class, 'data-id': entry.getId() },
            [
                { '_': 'div', 'class': 'col col-3', 'data-label': this.data.ident_1 },
                {
                    '_': 'span',
                    '__': is_released ? '{svg-stop}' : (is_immediate ? '{svg-triangle}' : ( is_soon ? '{svg-calendar}' : '' ) ),
                    '___': 'icon-sm',
                    'class': 'mode-colorblind' + (!is_released && !is_immediate && !is_soon ? ' hidden' : '' ),
                    'title': is_released ? 'Already released' : (is_immediate ? 'Will be released within 48 hours' : ( is_soon ? 'Will be released within a week' : '' ) ),
                },
                { '_': 'span', '__': entry.getIdent1() },
            ],
            { '_': 'div', '__': entry.getIdent2(), 'class': 'col col-3', 'data-label': this.data.ident_2 },
            { '_': 'div', '__': dateHumanReadable, 'class': 'col col-2', 'data-label': 'Release' },
            [
                { '_': 'div', 'class': 'col col-2', 'data-label': 'Settings' },
                [
                    { '_': 'div', 'class': 'dropdown is-right is-hoverable action-buttons' },
                    [
                        { '_': 'div', 'class': 'dropdown-trigger' },
                        [
                            { '_': 'a', 'href': '#', 'aria-controls': 'user-dropdown-menu' + this.data.ident_1 + '_' + j },
                            {
                                '_': 'a',
                                '__': '{svg-eye}',
                                'href': '#',
                                'class': 'icon current-visibility' + visibility_class,
                                'title': mapVisibility[visibility_class.trim()]
                            }
                        ],
                        [
                            { '_': 'div', 'id': 'user-dropdown-menu' + this.data.ident_1 + '_' + j, 'class': 'dropdown-menu', 'role': 'menu' },
                            [
                                { '_': 'div', 'class': 'dropdown-content' },
                                [
                                    { '_': 'div', 'class': 'dropdown-item change-visibility' },
                                    {
                                        '_': 'a', 'href': '#', '__': '{svg-eye-slash}',
                                        'class': 'v-is-hidden', 'data-visibility': '1',
                                        'title': 'Only visible on the website when logged in',
                                        'data-id': entry.getId()
                                    }
                                ],
                                [
                                    { '_': 'div', 'class': 'dropdown-item change-visibility' },
                                    {
                                        '_': 'a', 'href': '#', '__': '{svg-eye}',
                                        'class': 'v-is-private', 'data-visibility': '2',
                                        'title': 'Visible on the website when logged in and RSS',
                                        'data-id': entry.getId()
                                    }
                                ],
                                [
                                    { '_': 'div', 'class': 'dropdown-item change-visibility' },
                                    {
                                        '_': 'a', 'href': '#', '__': '{svg-eye}',
                                        'class': 'v-is-public', 'data-visibility': '4',
                                        'title': 'Visible everywhere',
                                        'data-id': entry.getId()
                                    }
                                ],
                            ]
                        ]
                    ]
                ],
                { '_': 'a', '__': '{svg-edit}', 'href': '#', 'class': 'edit-entry visible-hover', 'data-id': entry.getId() },
                { '_': 'a', '__': '{svg-trash}', 'href': '#', 'class': 'remove-entry visible-hover', 'data-id': entry.getId() }
            ]
        ];
        // is not logged in, there's no need for action buttons
        if (!isUser) { tr.splice(-1); }
        tbody[1].push(tr);
    }

    return [
        { '_': 'section', 'class': 'content' },
        { '_': 'h1', '__': this.data.name },
        tbody
    ];
};

/**
 * Creates an array with HTML structure for the Card display.
 * Uses the internal information on this Type object for entries.
 * 
 * @return  {Array}     An Array of HTML structure that can be build inside `createHTML()`
 */
Type.prototype.prepareCardHTMLArray = function() {
    let mapVisibility = {
        'v-is-hidden': 'Only visible on the website when logged in',
        'v-is-private': 'Visible on the website when logged in and RSS',
        'v-is-public': 'Visible everywhere'
    };

    let cards = [{ '_': 'div', 'class': 'columns card--' + this.data.name }];
    for (let j = 0; j < this.data.sortedList.length; ++j) {
        let entry = this.data.entries[this.data.mapEntryId2Index[this.data.sortedList[j]]];
        let _date = entry.getReleaseAt() === null ? 'TBA' : new Date(entry.getReleaseAt());
        let dateHumanReadable = _date;
        if (_date !== 'TBA') {
            dateHumanReadable = _date.toGMTString();
            let res = dateHumanReadable.match(new RegExp(".+?,.+? [0-9]{4}"));
            dateHumanReadable = res[0];
        }

        let is_released = +_date < +new Date;
        let is_soon = +_date < ( (+new Date) + 604800000 );         // a week
        let is_immediate = +_date < ( (+new Date) + 172800000 );    // 48 hours
        let date_class = is_released ? ' is-released' : (is_immediate ? ' is-immediate' : ( is_soon ? ' is-soon' : '' ) );
        let visibility_class =  entry.getVisibility() == 1 ? ' v-is-hidden' : ( entry.getVisibility() == 2 ? ' v-is-private' : ' v-is-public' );

        let _t = [
            { '_': 'section', 'class': 'card-item gajo-item' + date_class },
            [
                { '_': 'div', 'class': 'flip' },
                [
                    { '_': 'div', 'class': 'front' },
                    [
                        { '_': 'div', 'class': 'top' },
                        [
                            { '_': 'div', 'class': 'function-item edit-entry', 'data-id': entry.getId() },
                            { '_': 'a', '__': '{svg-edit}', 'href': '#' },
                        ],
                        [
                            { '_': 'div', 'class': 'function-item remove-entry', 'data-id': entry.getId() },
                            { '_': 'a', '__': '{svg-trash}', 'href': '#', 'class': '' }
                        ]
                    ],
                    [
                        { '_': 'div', 'class': 'entry-content' },
                        { '_': 'div', '__': entry.getIdent2(), 'class': 'ident-2', 'title': entry.getIdent2() },
                        [
                            { '_': 'div', '__': '', 'class': 'ident-1' },
                            { '_': 'div', '__': entry.getIdent1(), 'title': entry.getIdent1() },
                            { '_': 'div', '__': dateHumanReadable, 'data-timestamp': _date },
                        ]
                    ],
                    {
                        '_': 'span',
                        '__': is_released ? '{svg-stop}' : (is_immediate ? '{svg-triangle}' : ( is_soon ? '{svg-calendar}' : '' ) ),
                        '___': 'icon-md',
                        'class': 'mode-colorblind',
                        'title': is_released ? 'Already released' : (is_immediate ? 'Will be released within 48 hours' : ( is_soon ? 'Will be released within a week' : '' ) ),
                    },
                    [
                        { '_': 'div', 'class': 'function-item dropdown is-up is-right is-hoverable change-visibility' },
                        [
                            { '_': 'div', 'class': ' action-buttons' },
                            [
                                { '_': 'div', 'class': 'dropdown-trigger' },
                                [
                                    { '_': 'a', 'href': '#', 'aria-controls': 'user-dropdown-menu' + this.data.ident_1 + '_' + j },
                                    {
                                        '_': 'a',
                                        '__': '{svg-eye}',
                                        'href': '#',
                                        'class': 'icon current-visibility' + visibility_class,
                                        'title': mapVisibility[visibility_class.trim()],
                                    }
                                ],                            
                                [
                                    { '_': 'div', 'id': 'user-dropdown-menu' + this.data.ident_1 + '_' + j, 'class': 'dropdown-menu', 'role': 'menu' },
                                    [
                                        { '_': 'div', 'class': 'dropdown-content' },
                                        [
                                            { '_': 'div', 'class': 'dropdown-item change-visibility' },
                                            {
                                                '_': 'a', 'href': '#', '__': '{svg-eye-slash}',
                                                'class': 'v-is-hidden', 'data-visibility': '1',
                                                'title': 'Only visible on the website when logged in',
                                                'data-id': entry.getId()
                                            }
                                        ],
                                        [
                                            { '_': 'div', 'class': 'dropdown-item change-visibility' },
                                            {
                                                '_': 'a', 'href': '#', '__': '{svg-eye}',
                                                'class': 'v-is-private', 'data-visibility': '2',
                                                'title': 'Visible on the website when logged in and RSS',
                                                'data-id': entry.getId()
                                            }
                                        ],
                                        [
                                            { '_': 'div', 'class': 'dropdown-item change-visibility' },
                                            {
                                                '_': 'a', 'href': '#', '__': '{svg-eye}',
                                                'class': 'v-is-public', 'data-visibility': '4',
                                                'title': 'Visible everywhere',
                                                'data-id': entry.getId()
                                            }
                                        ],
                                    ]
                                ]
                            ]
                        ],
                    ],
                ],
                { '_': 'div', 'class': 'back'}  // fixes font rendering, smoothening it
            ]
        ];
        // is not logged in, there's no need for action buttons in footer
        if (!isUser) {
            _t[1][1][1].splice(1);
            _t[1][1].splice(-1);
        }
        cards.push(_t);
    }
    return [
        { '_': 'section', 'class': 'content' },
        { '_': 'h1', '__': this.data.name },
        cards
    ];
};

/**
 * Takes an array with HTML information and creates respective elements for it.
 * 
 * @param   {Array}         _arr        A specially formatted array of HTML information
 * @return  {HTMLElement}               The HTML structur created from the input array
 */
Type.prototype.createHTML = function(_arr) {
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

/**
 * In opposite to createHTML which takes in an Array structure of HTML to create,
 * this function starts the rendering process and calls `createHTML()` in the process.
 * If there is no target specified to hold the HTML, this Type's isDirty property will
 * still be true after this function call.
 * 
 * @param   {HTMLElement}   target  The (optional) target holding the HTML
 * @param   {boolean}       clear   True by default, removes any previous content inside target, set to false if appendChild only is desired
 * @return  {HTMLElement}           The DOM Elements that were created
 */
Type.prototype.renderHTML = function(target, clear = true) {
    // Prevent empty section being displayed
    if (!this.data.sortedList.length) {
        if (clear) {
            if (clear) { target.innerHTML = ''; }
        }
        return;
    }

    let html = undefined;
    if (this.data.display == 1) {
        html = this.createHTML(this.prepareTableHTMLArray());
    } else if (this.data.display == 2) {
        html = this.createHTML(this.prepareCardHTMLArray());
    }

    if (target !== undefined && target !== null) {
        if (clear) { target.innerHTML = ''; }
        target.appendChild(html);
        this.data.dirtyHTML = false;
    } else {
        return html;
    }
};

/**
 * Sorts all entries based on the provided parameter that matches any data property.
 * Saves that to an internal config for reuse.
 * If no parameter to sort by is provided a previously saved on is used.
 * Default sorting is by ident_1.
 * 
 * @param   {string}    sortBy      The property to sort by, if not provided ident_1 is used
 */
Type.prototype.sort = function(sortBy) {
    if (!sortBy) { sortBy = this.config.sortBy; }
    else {
        // toggling works only with a set sortBy, this is because addEntry would toggle the sorting each adding
        if (this.config.sortBy === sortBy) {
            this.config.sortOrderAsc = !this.config.sortOrderAsc;
        }
        this.config.sortBy = sortBy;
    }

    // prevent invalid save of non-present property, use fallback of default value
    if (this.data.entries.length > 0 && typeof(this.data.entries[0].data[sortBy]) === 'undefined') {
        this.config.sortBy = 'ident_1';
        sortBy = 'ident_1';
        this.config.sortOrderAsc = true;
    }

    let sortByNotTime = sortBy !== 'release_at';  // cheaper to compare
    this.data.sortedList.sort((a, b) => {
        // release_at is special case
        if (sortByNotTime) {
            return (this.config.sortOrderAsc ? 1 : -1) * this.data.entries[this.data.mapEntryId2Index[a]].data[sortBy].localeCompare(this.data.entries[this.data.mapEntryId2Index[b]].data[sortBy]);
        } else {
            // makes sure, TBA is always at the bottom
            if (this.data.entries[this.data.mapEntryId2Index[a]].data[sortBy] === null) { return 1; }
            if (this.data.entries[this.data.mapEntryId2Index[b]].data[sortBy] === null) { return -1; }

            return (this.config.sortOrderAsc ? 1 : -1) *  (new Date(this.data.entries[this.data.mapEntryId2Index[a]].data[sortBy]) - new Date(this.data.entries[this.data.mapEntryId2Index[b]].data[sortBy]));
        }
    });
    this.setDirty();
};