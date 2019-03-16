export default function Entry(config = {}) {
    if (!(this instanceof Entry)) {
        return new Entry(config);
    }

    this.data = {
        id: config.id,
        ident_1: config.ident_1,
        ident_2: config.ident_2,
        release_at: config.release_at,
        visibility: config.visibility,
        belongsTo: config.belongsTo || undefined
    };
}

/**
 * Gets the ID of this Entry.
 * Used for anything that needs change server side.
 * 
 * @return  {integer}   The unique ID of this Entry
 */
Entry.prototype.getId = function() {
    return this.data.id;
};

/**
 * Gets the Ident_1 of this Entry.
 * 
 * @return  {string}   The ident_1 of this Entry
 */
Entry.prototype.getIdent1 = function() {
    return this.data.ident_1;
};

/**
 * Sets the ident_1 for this Entry.
 * 
 * @param   {string}    _new    The new ident_1
 */
Entry.prototype.setIdent1 = function(_new) {
    this.data.ident_1 = _new;
};

/**
 * Gets the Ident_2 of this Entry.
 * 
 * @return  {string}   The ident_2 of this Entry
 */
Entry.prototype.getIdent2 = function() {
    return this.data.ident_2;
};

/**
 * Sets the ident_2 for this Entry.
 * 
 * @param   {string}    _new    The new ident_2
 */
Entry.prototype.setIdent2 = function(_new) {
    this.data.ident_2 = _new;
};

/**
 * Gets the relase date for this Entry.
 * 
 * @return  {string}   The release date for this Entry
 */
Entry.prototype.getReleaseAt = function() {
    return this.data.release_at;
};

/**
 * Sets the relase date for this Entry.
 * 
 * @param   {string}    _new    The new release date
 */
Entry.prototype.setReleaseAt = function(_new) {
    this.data.release_at = _new;
};

/**
 * Gets the visibility for this Entry.
 * There are currently three available states:
 * 1: hidden,
 * 2: private,
 * 4: public
 * 
 * @return  {integer}   The visibility of this Entry
 */
Entry.prototype.getVisibility = function() {
    return this.data.visibility;
};

/**
 * Sets the visibility of this Entry.
 * There are currently three available states:
 * 1: hidden,
 * 2: private,
 * 4: public
 * 
 * @param  {integer}    _new    The visibility of this Entry
 */
Entry.prototype.setVisibility = function(_new) {
    this.data.visibility = _new;
};

/**
 * Each Entry usually hasOne Type it belongs to.
 * This function returns that "parent".
 * 
 * @return  {Type}      The type this Entry belongs to, can be undefined if non was set
 */
Entry.prototype.parent = function() {
    return this.data.belongsTo;
};

/**
 * Helper function to "directly" delete an Entry by using the relationship,
 * instead of searching inside each Type entries.
 * Calls the Topic's deleteEntry function.
 * 
 * @return {boolean}    Returns the parent's func return value, false if belongsTo relationship is not set
 */
Entry.prototype.delete = function() {
    if (this.data.belongsTo) {
        return this.data.belongsTo.deleteEntry(this.data.id);
    }

    return false;
};