let Entry = function(entry) {
    if (!(this instanceof Entry)) {
        return new Entry(entry);
    }

    this.entry = entry;
};
Entry.prototype.getHTML = function() {
    let _date = this.entry['release_at'] === null ? 'TBA' : new Date(this.entry['release_at']);
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
    let visibility_class = this.entry['visibility'] == 1 ? ' v-is-hidden' : ( this.entry['visibility'] == 2 ? ' v-is-private' : ' v-is-public' );

    if (this.entry['type']['display'] == 1) {
        let tr = [
            { '_': 'li', 'class': 'table-row' + date_class, 'data-id': this.entry['id'] },
            [
                { '_': 'div', 'class': 'col col-3', 'data-label': this.entry['ident_1'] },
                {
                    '_': 'span',
                    '__': is_released ? '{svg-stop}' : (is_immediate ? '{svg-triangle}' : ( is_soon ? '{svg-calendar}' : '' ) ),
                    '___': 'icon-sm',
                    'class': 'mode-colorblind' + (!is_released && !is_immediate && !is_soon ? ' hidden' : '' ),
                    'title': is_released ? 'Already released' : (is_immediate ? 'Will be released within 48 hours' : ( is_soon ? 'Will be released within a week' : '' ) ),
                },
                { '_': 'span', '__': this.entry['ident_1'] },
            ],
            { '_': 'div', '__': this.entry['ident_2'], 'class': 'col col-3', 'data-label': this.entry['ident_2'] },
            { '_': 'div', '__': dateHumanReadable, 'class': 'col col-2', 'data-label': 'Release' },
            [
                { '_': 'div', 'class': 'col col-2', 'data-label': 'Settings' },
                [
                    { '_': 'div', 'class': 'dropdown is-right is-hoverable action-buttons' },
                    [
                        { '_': 'div', 'class': 'dropdown-trigger' },
                        [
                            { '_': 'a', 'href': '#', 'aria-controls': 'user-dropdown-menu' + this.entry['type']['ident_1'] + '_' + this.entry['id'] },
                            {
                                '_': 'a',
                                '__': '{svg-eye}',
                                'href': '#',
                                'class': 'icon current-visibility' + visibility_class,
                                'title': mapVisibility[visibility_class.trim()]
                            }
                        ],
                        [
                            { '_': 'div', 'id': 'user-dropdown-menu' + this.entry['type']['ident_1'] + '_' + this.entry['id'], 'class': 'dropdown-menu', 'role': 'menu' },
                            [
                                { '_': 'div', 'class': 'dropdown-content' },
                                [
                                    { '_': 'div', 'class': 'dropdown-item change-visibility' },
                                    {
                                        '_': 'a', 'href': '#', '__': '{svg-eye-slash}',
                                        'class': 'v-is-hidden', 'data-visibility': '1',
                                        'title': 'Only visible on the website when logged in',
                                        'data-id': this.entry['id']
                                    }
                                ],
                                [
                                    { '_': 'div', 'class': 'dropdown-item change-visibility' },
                                    {
                                        '_': 'a', 'href': '#', '__': '{svg-eye}',
                                        'class': 'v-is-private', 'data-visibility': '2',
                                        'title': 'Visible on the website when logged in and RSS',
                                        'data-id': this.entry['id']
                                    }
                                ],
                                [
                                    { '_': 'div', 'class': 'dropdown-item change-visibility' },
                                    {
                                        '_': 'a', 'href': '#', '__': '{svg-eye}',
                                        'class': 'v-is-public', 'data-visibility': '4',
                                        'title': 'Visible everywhere',
                                        'data-id': this.entry['id']
                                    }
                                ],
                            ]
                        ]
                    ]
                ],
                { '_': 'a', '__': '{svg-edit}', 'href': '#', 'class': 'edit-entry visible-hover', 'data-id': this.entry['id'] },
                { '_': 'a', '__': '{svg-trash}', 'href': '#', 'class': 'remove-entry visible-hover', 'data-id': this.entry['id'] }
            ]
        ];
        // is not logged in, there's no need for action buttons
        if (!isUser) { tr.splice(-1); }

        return createElements(tr);
    } else {
        let _t = [
            { '_': 'section', 'class': 'card-item gajo-item' + date_class },
            [
                { '_': 'div', 'class': 'flip' },
                [
                    { '_': 'div', 'class': 'front' },
                    [
                        { '_': 'div', 'class': 'top' },
                        [
                            { '_': 'div', 'class': 'function-item edit-entry', 'data-id': this.entry['id'] },
                            { '_': 'a', '__': '{svg-edit}', 'href': '#' },
                        ],
                        [
                            { '_': 'div', 'class': 'function-item remove-entry', 'data-id': this.entry['id'] },
                            { '_': 'a', '__': '{svg-trash}', 'href': '#', 'class': '' }
                        ]
                    ],
                    [
                        { '_': 'div', 'class': 'entry-content' },
                        { '_': 'div', '__': this.entry['ident_2'], 'class': 'ident-2', 'title': this.entry['ident_2'] },
                        [
                            { '_': 'div', '__': '', 'class': 'ident-1' },
                            { '_': 'div', '__': this.entry['ident_1'], 'title': this.entry['ident_1'] },
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
                                    { '_': 'a', 'href': '#', 'aria-controls': 'user-dropdown-menu' + this.entry['type']['ident_1'] + '_' + this.entry['id'] },
                                    {
                                        '_': 'a',
                                        '__': '{svg-eye}',
                                        'href': '#',
                                        'class': 'icon current-visibility' + visibility_class,
                                        'title': mapVisibility[visibility_class.trim()],
                                    }
                                ],                            
                                [
                                    { '_': 'div', 'id': 'user-dropdown-menu' + this.entry['type']['ident_1'] + '_' + this.entry['id'], 'class': 'dropdown-menu', 'role': 'menu' },
                                    [
                                        { '_': 'div', 'class': 'dropdown-content' },
                                        [
                                            { '_': 'div', 'class': 'dropdown-item change-visibility' },
                                            {
                                                '_': 'a', 'href': '#', '__': '{svg-eye-slash}',
                                                'class': 'v-is-hidden', 'data-visibility': '1',
                                                'title': 'Only visible on the website when logged in',
                                                'data-id': this.entry['id']
                                            }
                                        ],
                                        [
                                            { '_': 'div', 'class': 'dropdown-item change-visibility' },
                                            {
                                                '_': 'a', 'href': '#', '__': '{svg-eye}',
                                                'class': 'v-is-private', 'data-visibility': '2',
                                                'title': 'Visible on the website when logged in and RSS',
                                                'data-id': this.entry['id']
                                            }
                                        ],
                                        [
                                            { '_': 'div', 'class': 'dropdown-item change-visibility' },
                                            {
                                                '_': 'a', 'href': '#', '__': '{svg-eye}',
                                                'class': 'v-is-public', 'data-visibility': '4',
                                                'title': 'Visible everywhere',
                                                'data-id': this.entry['id']
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

        return createElements(_t);
    }
};

let Section = function(id, name, display, ident_1, ident_2) {
    if (!(this instanceof Section)) {
        return new Section(id, name, display, ident_1, ident_2);
    }

    this.id = id;
    this.name = name;
    this.display = display;
    this.ident_1 = ident_1;
    this.ident_2 = ident_2;

    this.entries = [];
    this.html = undefined;
};

Section.prototype.addEntry = function(entry) {
    let objEntry = new Entry(entry);
    this.entries.push(objEntry);
    return objEntry;
};
Section.prototype.addEntries = function(entries) {
    for (let i = 0; i < entries.length; ++i) {
        this.addEntry(entries[i]);
    }
};

Section.prototype.createHTML = function() {
    let section = document.createElement('section');
        section.classList.add('content');

    let header = document.createElement('h1');
        header.innerHTML = this.name;
    section.appendChild(header);

    if (this.display == 1) {
        let container = document.createElement('div');
            container.classList.add('table-item', 'table--' + this.name);
        let ul = document.createElement('ul');
            ul.classList.add('responsive-table');

        let ul__header = document.createElement('li');
            ul__header.classList.add('table-header');

        let ul__header__col1 = document.createElement('div');
            ul__header__col1.classList.add('col', 'col-3');
            ul__header__col1.innerHTML = this.ident_1;
        ul__header.appendChild(ul__header__col1);

        let ul__header__col2 = document.createElement('div');
            ul__header__col2.classList.add('col', 'col-3');
            ul__header__col2.innerHTML = this.ident_2;
        ul__header.appendChild(ul__header__col2);

        let ul__header__col3 = document.createElement('div');
            ul__header__col3.classList.add('col', 'col-2');
            ul__header__col3.innerHTML = 'Release';
        ul__header.appendChild(ul__header__col3);
        if (isUser) {
            let ul__header__col4 = document.createElement('div');
                ul__header__col4.classList.add('col', 'col-2');
                ul__header__col4.innerHTML = '&nbsp;';
            ul__header.appendChild(ul__header__col4);
        }
        ul.appendChild(ul__header);
        for (let i = 0; i < this.entries.length; ++i) {
            ul.appendChild(this.entries[i].getHTML());
        }
        container.appendChild(ul);
        section.appendChild(container);    
    } else {
        let container = document.createElement('div');
            container.classList.add('columns', 'card--' + this.name);

        for (let i = 0; i < this.entries.length; ++i) {
            container.appendChild(this.entries[i].getHTML());
        }
        section.appendChild(container);    
    }

    this.html = section;
    return this.html;
};

window.sections = [];
for (let i = 0; i < USER_TYPES.length; ++i) {
    let s = new Section(
        USER_TYPES[i]['id'],
        USER_TYPES[i]['name'],
        USER_TYPES[i]['display'],
        USER_TYPES[i]['ident_1'],
        USER_TYPES[i]['ident_2'],
    );
    s.addEntries(ENTRIES[USER_TYPES[i]['sort'] + '_' + USER_TYPES[i]['name']].data);
    $('.container-entries').appendChild(s.createHTML());
    window.sections.push(s);
}