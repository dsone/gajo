export default function ModalEntry(config = {}) {
    if (!(this instanceof ModalEntry)) {
        return new ModalEntry(config);
    }

    this.config = {
        modal: config.modal,                    // modal object itself, used as context for querySelectors

        type_select: config.type_select,        // the type to add

        ident_1_title: config.ident_1_title,    // ident_1 header
        ident_1_input: config.ident_1_input,    // ident_1 input

        ident_2_title: config.ident_2_title,    // ident_2 header
        ident_2_input: config.ident_2_input,    // ident_2 input

        release_input: config.release_input,    // release date input
        visibility: [                           // visiblity of entry, radiobuttons, left to right
            config.visibility[0],  // hidden
            config.visibility[1], // private
            config.visibility[2]   // public
        ],

        btnAdd: config.btnAdd,                   // Button confirming the new entry
        btnCancel: config.btnCancel,             // Button(s) cancelling the action
        user_types: config.user_types            // The user types object to create the select from
    };

    this.data = {
        entryId: undefined,                      // when this object is used to edit an entry, this will hold the entry id
        lastSelectedTypeId: undefined,           // pre-select last selected type if available
        hasError: false,                         // when any input is invalid, this is true
    };

    // Header and placeholder needs to change on select change event
    this.config.type_select.addEventListener('change', (e) => {
        let selOption = e.currentTarget.options[e.currentTarget.selectedIndex];
        let id = selOption.value;
        this.data.lastSelectedTypeId = id;

        this.setIdent1Title(selOption.getAttribute('data-ident1'));
        this.setIdent2Title(selOption.getAttribute('data-ident2'));
    });

    // Set optional events for submit/abort
    if (config.submitCB) {
        this.config.btnAdd.addEventListener('click', config.submitCB);
    }
    if (config.cancelCB) {
        this.config.btnCancel.forEach(function(el) {
            el.addEventListener('click', config.cancelCB);
        });
    }

    this.renderSelectOptions();
};

/**
 * Gets the selected DOM Element option.
 * 
 * @return  {HTMLOptionElement}     The selected element
 */
ModalEntry.prototype.getSelectedTypeOption = function() {
    return this.config.type_select.options[this.config.type_select.selectedIndex];
};
/**
 * Sets the selected DOM Element option.
 * 
 * @param  {integer}        The selected option by its value
 * @return {boolean}        True when the desired value was found and set, false otherwise
 */
ModalEntry.prototype.setSelectedTypeOption = function(selected) {
    let opts = this.config.type_select.options;
    for (let i = 0; i < opts.length; ++i) {
        if (opts[i].value == selected) {
            this.config.type_select.selectedIndex = i;
            return true;
        }   
    }
    return false;
};

/**
 * Sets the ident_1 property innerHTML and placeholder of 
 * corresponding input.
 * 
 * @param   {string}    title       The new title for ident_1
 */
ModalEntry.prototype.setIdent1Title = function(title) {
    this.config.ident_1_title.innerHTML = title;
    this.config.ident_1_input.setAttribute('placeholder', title);
};
/**
 * Gets the ident_1 input.
 * 
 * @return  {string}    The input
 */
ModalEntry.prototype.getIdent1Input = function() {
    return this.config.ident_1_input.value;
};
/**
 * Sets the ident_1 input.
 * 
 * @param  {string}     input       The new input
 */
ModalEntry.prototype.setIdent1Input = function(input) {
    this.config.ident_1_input.value = input;
};

/**
 * Sets the ident_2 property innerHTML and placeholder of 
 * corresponding input.
 * 
 * @param   {string}    title       The new title for ident_2
 */
ModalEntry.prototype.setIdent2Title = function(title) {
    this.config.ident_2_title.innerHTML = title;
    this.config.ident_2_input.setAttribute('placeholder', title);
}
/**
 * Gets the ident_2 input.
 * 
 * @return  {string}    The input
 */
ModalEntry.prototype.getIdent2Input = function() {
    return this.config.ident_2_input.value;
};
/**
 * Sets the ident_2 input.
 * 
 * @param  {string}     input       The new input
 */
ModalEntry.prototype.setIdent2Input = function(input) {
    this.config.ident_2_input.value = input;
};

/**
 * Gets the release_at input.
 * 
 * @return  {string}    The input
 */
ModalEntry.prototype.getReleaseInput = function() {
    return this.config.release_input.value;
};
/**
 * sets the release_at input.
 * 
 * @param   {string}    input   The new release, date or null
 */
ModalEntry.prototype.setReleaseInput = function(input) {
    if (input !== null && input.indexOf("T") > -1) {
        // new Date().toISOString generates Zulu Time,
        // but to set date inputs we need the part before T
        input = input.substring(0, input.indexOf("T"));
    }
    this.config.release_input.value = input;
};

/**
 * Gets the currently selected visibility Element.
 * 
 * @return  {HTMLElement}       The radio element currently selected
 */
ModalEntry.prototype.getVisibility = function() {
    let checked = undefined;
    this.config.visibility.some(function(e) {
        if (e.checked) {
            checked = e;
            return true
        }
        return false;
    });
    return checked;
};

/**
 * Sets the currently selected visibility Element.
 * 
 * @param  {integer}    visibility       The radio element to set as selected
 */
ModalEntry.prototype.setVisibility = function(visibility) {
    this.config.visibility.some(function(e) {
        if (e.getAttribute('data-visibility') == visibility) {
            e.click();
            return true;
        }
    });
};

/**
 * Gets the entry id, only set, when object is used to edit an Entry.
 * 
 * @return   {integer}      The entry id being edited
 */
ModalEntry.prototype.getEntryId = function() {
    return this.config.entryId;
};

/**
 * Sets the entry id.
 * 
 * @param   {integer}   entryId     The entry id being edited
 */
ModalEntry.prototype.setEntryId = function(entryId) {
    this.config.entryId = entryId;
};

/**
 * Validates the input.
 * Currently only checks for ident_1 being non-empty.
 * `getEntryData()` calls this before trying to return data.
 * 
 * @return  {boolean}   True if valid input, false otherwise
 */
ModalEntry.prototype.validateInput = function() {
    // Elements to validate, currently only for non-empty input
    let loopThrough = [
        this.config.ident_1_input
    ];

    let foundError = false;
    loopThrough.forEach((el) => {
        if (el.value.length === 0) {
            el.classList.add('is-danger');
            foundError = true;
        } else {
            el.classList.remove('is-danger');
        }
    });
    this.data.hasError = foundError;
    return !foundError;
};

/**
 * Returns a JSON literal used for AJAX requests.
 * Calls `validateInput()` before returning that data.
 * 
 * @return  {JSON}      The JSON represenation for the entered data, undefined if validateInput failed
 */
ModalEntry.prototype.getEntryData = function() {
    if (!this.validateInput()) { return undefined; }

    return {
        id: this.getEntryId(),  // undefined for non-edit mode
        ident_1: this.getIdent1Input(),
        ident_2: this.getIdent2Input() || 'TBA',
        release_at: this.getReleaseInput().length > 0 ? new Date(this.getReleaseInput()).toISOString() : null,
        visibility: +(this.getVisibility().getAttribute('data-visibility')),
        type_id: +(this.getSelectedTypeOption().value)
    };
};

/**
 * Renders the select options.
 */
ModalEntry.prototype.renderSelectOptions = function() {
    this.config.type_select.innerHTML = '';
    for (let i = 0; i < this.config.user_types.length; ++i) {
        let option = document.createElement('option');
            option.value = this.config.user_types[i]['id'];
            option.innerText = this.config.user_types[i]['name'] + ' (' + (this.config.user_types[i]['display'] == 1 ? 'List Display' : 'Card Display') + ')';
            option.setAttribute('data-ident1', this.config.user_types[i]['ident_1']);
            option.setAttribute('data-ident2', this.config.user_types[i]['ident_2']);

        this.config.type_select.appendChild(option);
        if (option.value == this.data.lastSelectedTypeId || this.config.user_types.length === 1) {
            this.config.type_select.selectedIndex = i;
        }
    }
};

/**
 * Closes the modal by triggering a btnCancel click.
 */
ModalEntry.prototype.close = function() {
    if (this.config.btnCancel.length > 0) {
        this.config.btnCancel[0].click();
    } else {
        this.config.modal.classList.remove('is-active');
    }
};

/**
 * Opens the modal by setting the active class.
 */
ModalEntry.prototype.open = function(data) {
    if (data) {
        for (let func in data) {
            if (typeof(this[`set${func}`]) !== 'undefined') {
                this[`set${func}`](data[func]);
            }
        }
    }
    this.config.modal.classList.add('is-active');
};

/**
 * Empties put the input.
 */
ModalEntry.prototype.clearInput = function() {
    this.setIdent1Input('');
    this.setIdent2Input('');
    this.setReleaseInput('');
    // visibility is not changed, since another entry can have the same visibility
};