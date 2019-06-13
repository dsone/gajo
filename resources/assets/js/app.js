import Type from './components/Type';
import ModalEntry from './components/ModalEntry';
import Options from './components/Options';
import Notify from './components/Notify';

// https://stackoverflow.com/a/872537
/*window.scrollTop = function() {
    if (typeof pageYOffset!= 'undefined') {
        return pageYOffset;
    } else {
        let B = document.body; //IE 'quirks'
        let D = document.documentElement; //IE with doctype
            D = (D.clientHeight)? D: B;
        return D.scrollTop;
    }
}*/

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

// Helper function to get a specific SVG clone
var __SVG = [];
window.SVG = function(type) {
    if (typeof(__SVG[type]) === 'undefined') { return null; }
    return $(__SVG[type]).cloneNode(true);
};

// Helper to get a specific entry by reference(!)
window.getEntryById = function(id) {
    let entry = undefined;
    // Some loops over all elements until some returns true,
    // then the some func returns true as well, skipping all leftover elements
    window.TYPES.some(function(e) {
        entry = e.getEntry(id);
        if (entry) { return true; }
        return false;
    });
    return entry;
};

(function() {
    window.isUser = $('body').classList.contains('is-user');
    window.isColorBlind = $('body').classList.contains('is-colorblind');

    // Initiate the closing of modal dialogs
    let modals = $$('.modal');
    if (modals) {
        for (let i = 0; i < modals.length; ++i) {
            let btnClose = $$('.close-modal', modals[i]);
            if (btnClose) {
                for (let j = 0; j < btnClose.length; ++j) {
                    btnClose[j].addEventListener('click', function(e) {
                        modals[i].classList.remove('is-active');
                    });
                }
            }
        }

        let body = document.body;
        body.addEventListener('keyup', (el) => {
            let isOpenModal = $('.modal.is-active');
            if (isOpenModal) {
                switch (el.charCode || el.keyCode) {
                    case 13:
                        let btnPrimary = $('.modal-card-foot .is-primary', isOpenModal);
                        if (btnPrimary) { btnPrimary.click(); }
                    break;
                    
                    case 27:
                        let btnClose = $('.modal-card-foot .close-modal', isOpenModal);
                        if (btnClose) { btnClose.click(); }
                    break;
                    default: break;
                }
            }
        });
    }

    
    

    // Initiate the opening of modals through data-target
    let modalTargets = $$('[data-target]');
    if (modalTargets) {
        for (let i = 0; i < modalTargets.length; ++i) {
            let modalDlg = $(modalTargets[i].getAttribute('data-target'));
            if (modalDlg) {
                modalTargets[i].addEventListener('click', function(e) {
                    modalDlg.classList.add('is-active');
                });
            }
        }
    }


    // create a list of available svgs to clone
    let createSVGList = function(parentSelector, childSelector) {
        // let's ready up the available svgs
        let svg = $$( parentSelector + ' ' + childSelector );
        for (let s = 0; s < svg.length; ++s) {
            __SVG[ '{' + svg[s].className + '}' ] = parentSelector + ' .' + svg[s].className;
            __SVG[ svg[s].className ] = parentSelector + ' ' + svg[s].className;
        }
    };
    createSVGList('.svg-container', 'span');


    let api = {
        post: function(url, data, cbDone, cbError) {
            let doneCallback = cbDone !== undefined ? cbDone : function(resp) { console.log(resp); };
            let errorCallback = cbError !== undefined ? cbError : function(resp) { console.log(resp); };

            axios.post(url, Object.assign({}, data))
                 .then(doneCallback)
                 .catch(errorCallback)
        },
        put: function(url, data, cbDone, cbError) {
            let doneCallback = cbDone !== undefined ? cbDone : function(resp) { console.log(resp); };
            let errorCallback = cbError !== undefined ? cbError : function(resp) { console.log(resp); };

            axios.put(url, Object.assign({}, data))
                 .then(doneCallback)
                 .catch(errorCallback)
        },
        get: function(url, cbDone, cbError) {
            let doneCallback = cbDone !== undefined ? cbDone : function(resp) { console.log(resp); };
            let errorCallback = cbError !== undefined ? cbError : function(resp) { console.log(resp); };

            axios.get(url)
                 .then(doneCallback)
                 .catch(errorCallback)
        }
    };


    // Create the HTML based on the embedded global ENTRIES
    window.TYPES = [];
    Object.keys(ENTRIES).sort().forEach(function(type, i) {
        //Create the Type
        window.TYPES.push(new Type({
            id: +ENTRIES[type].type.id,
            name: ENTRIES[type].type.name,
            ident_1: ENTRIES[type].type.ident_1,
            ident_2: ENTRIES[type].type.ident_2,
            sort: +ENTRIES[type].type.sort,
            display: +ENTRIES[type].type.display
        }));

        // Loop through the type's entries and add the to the above Type
        ENTRIES[type].data.forEach(function(entry) {
            window.TYPES[i].addEntry({
                id: +entry.id,
                ident_1: entry.ident_1,
                ident_2: entry.ident_2,
                release_at: entry.release_at,
                visibility: +entry.visibility,
            });
        });

        // Create the HTML Elements
        window.TYPES[i].renderHTML($('.container-entries'), i < 1);
    });
    if (window.TYPES.length === 0) {
        let container = $('.container-entries');
        if (container) {
            $('.container-entries').innerHTML = 'No Entries yet!';
        }
    }


    if (isUser) {
        let btnAddEntry = $('.js-link-add-entry');
        if (btnAddEntry) {
            let modalAddEntry = $('#modal-add-entry');
        
            btnAddEntry.addEventListener('click', function(e) {
                if (USER_TYPES.length == 0) {
                    notify('Wait...', 'You have to add a type first!<br>See Options how to do that.', 'warning');
                    let abort = $('.close-modal', modalAddEntry);
                    abort.click();
                    return;
                } else {
                    // for some reason the default setting in markup is not checked
                    // switching from dblclick of an entry to clicking the button leads to unchecked radio button
                    // hence forcing it here
                    $('input[data-visibility="1"]', modalAddEntry).click();
                }
            });

            window.modalAdd = new ModalEntry({
                modal: modalAddEntry,
                type_select: $('.js-entry-type', modalAddEntry),
                ident_1_title: $('.js-add-ident1', modalAddEntry),
                ident_1_input: $('.js-new-entry-ident-1', modalAddEntry),
                ident_2_title: $('.js-add-ident2', modalAddEntry),
                ident_2_input: $('.js-new-entry-ident-2', modalAddEntry),
                release_input: $('.js-new-entry-release-at', modalAddEntry),
                visibility: [
                    $('#ne-opt-hidden', modalAddEntry),
                    $('#ne-opt-private', modalAddEntry),
                    $('#ne-opt-public', modalAddEntry)
                ],
                btnAdd: $('.save-modal', modalAddEntry),
                btnCancel: $$('.close-modal', modalAddEntry),
                user_types: window.USER_TYPES,
                submitCB: function(event) {
                    if ($('.save-modal', modalAddEntry).classList.contains('is-loading')) { return; }

                    // internally validates input, returns undefined if invalid input
                    let data = window.modalAdd.getEntryData();
                    if (data === undefined) { return; }

                    $('.save-modal', modalAddEntry).classList.add('is-loading');
                    api.post(
                        '/api/v1/entry',
                        data,
                        function(json) {
                            if (!json.data.error) {
                                try {
                                    window.modalAdd.clearInput();

                                    if (window.TYPES.length) {
                                        let found = window.TYPES.some(function(type) {
                                            if (type.getId() === data.type_id) {
                                                type.addEntry({
                                                    id: json.data.entry.id,
                                                    ident_1: data.ident_1,
                                                    ident_2: data.ident_2,
                                                    release_at: data.release_at,
                                                    visibility: data.visibility,
                                                });
                                                return true;
                                            }
                                            return false;
                                        });
                                        if (!found) {
                                            // may another type was firstly added
                                            location.reload();
                                        }
                                    } else {
                                        // ENTRIES and TYPES are empty, when this is the first added entry
                                        location.reload();
                                    }


                                    window.TYPES.forEach(function(e, i) {
                                        e.renderHTML($('.container-entries'), i < 1)
                                    });
                                    bindEntryEvents();

                                    notify('Saved!', 'Entry was added', 'success');
                                } catch (e) {
                                    console.error(e);
                                }
                            } else {
                                notify('Error!', 'Could not add entry', 'danger');
                            }
                            $('.save-modal', modalAddEntry).classList.remove('is-loading');
                            
                            window.modalAdd.close();
                        },  // success callback
                        function(json) {
                            $('.save-modal', modalAddEntry).classList.remove('is-loading');
                            notify('Error!', 'Could not add entry', 'danger');
                        }  // error callback
                    );
                },
                cancelCB: function(event) {}
            });

            // Setup first label to prevent awkward element jumping, is overwritten when clicking the button to add a new entry
            if (USER_TYPES.length > 0) {
                window.modalAdd.setIdent1Title(USER_TYPES[0]['ident_1']);
                window.modalAdd.setIdent2Title(USER_TYPES[0]['ident_2']);
            }
        }


        let modalEditEntry = $('#modal-edit-entry');
        window.modalEdit = new ModalEntry({
            modal: modalEditEntry,
            type_select: $('.js-edit-entry-type', modalEditEntry),
            ident_1_title: $('.js-edit-ident1', modalEditEntry),
            ident_1_input: $('.entry-ident1', modalEditEntry),
            ident_2_title: $('.js-edit-ident2', modalEditEntry),
            ident_2_input: $('.entry-ident2', modalEditEntry),
            release_input: $('.entry-release-at', modalEditEntry),
            visibility: [
                $('#ee-opt-hidden', modalEditEntry),
                $('#ee-opt-private', modalEditEntry),
                $('#ee-opt-public', modalEditEntry)
            ],
            btnAdd: $('.edit-modal', modalEditEntry),
            btnCancel: $$('.close-modal', modalEditEntry), 
            user_types: window.USER_TYPES,
            submitCB: function(event) {
                if ($('.edit-modal', modalEditEntry).classList.contains('is-loading')) { return; }

                // internally validates input, returns undefined if invalid input
                let data = window.modalEdit.getEntryData();
                if (data === undefined) { return; }

                let entry = getEntryById(data.id);
                // check if the type was changed
                let changedType = false;
                if (entry.parent().getId() != data.type_id) {
                    changedType = true;
                }

                $('.edit-modal', modalEditEntry).classList.add('is-loading');
                api.put(
                    '/api/v1/entry',
                    data,
                    function(json) {
                        try {
                            if (!json.data.error) {
                                // The type was changed and the entry must be inserted into another table/card display
                                if (changedType) {
                                    entry.delete();  // removes itself from the parent Type, the object itself is not deleted and can be reused
                                    window.TYPES.some(function(e) {
                                        let type_id = e.getId();
                                        if (type_id === data.type_id) {
                                            e.addEntry({
                                                id: +entry.getId(),
                                                ident_1: entry.getIdent1(),
                                                ident_2: entry.getIdent2(),
                                                release_at: entry.getReleaseAt(),
                                                visibility: +entry.getVisibility(),
                                            });
                                            e.setDirty();
                                            return true;
                                        }
                                        return false;
                                    });
                                } else {
                                    entry.setIdent1(data.ident_1);
                                    entry.setIdent2(data.ident_2);
                                    entry.setReleaseAt(data.release_at);
                                    entry.setVisibility(data.visibility);
                                    entry.parent().setDirty();
                                }

                                // Update list display
                                window.TYPES.forEach(function(e, i) {
                                    e.renderHTML($('.container-entries'), i < 1);
                                });
                                bindEntryEvents();

                                window.modalEdit.close();
                                window.modalEdit.clearInput();
                            
                                notify('Saved!', 'Entry was changed', 'success');
                            } else {
                                notify('Failed!', json.data.message, 'danger');
                            }

                            $('.edit-modal', modalEditEntry).classList.remove('is-loading');
                        } catch (e) { console.error(e); }
                    },  // success callback
                    function(a) {
                        $('.edit-modal', modalEditEntry).classList.remove('is-loading');
                        notify('Error!', 'Could not change entry', 'danger');
                    }  // error callback
                );
            },
            cancelCB: function(event) {}
        });

        // Options page
        if ($('.js-page-options')) {
            let funcOptionsUpdate = function(e) {
                let checkBox = e.currentTarget;
                let data = window.options.getOptions();

                if (checkBox.classList.contains('is-loading')) { return; }
                checkBox.classList.add('is-loading');

                api.put(
                    '/api/v1/options', data,
                    function(a) {
                        notify('Saved!', 'Your options were saved', 'success');
                        checkBox.classList.remove('is-loading');
                    },  // success callback
                    function(a) {
                        checkBox.checked = !checkBox.checked;  // reset
                        checkBox.classList.remove('is-loading');
                        notify('Error!', 'Could not save your profile settings. Reset!', 'danger');
                    }  // error callback
                );
            };
            window.options = new Options({
                checkbox_private_profile: $('#private-profile'),
                checkbox_colorblind_mode: $('#colorblind-mode'),
                check_hide_released: $('#hide-released'),
                check_hide_tba: $('#hide-tba'),
                btnRSSChange: $('.js-btn-change-rss'),
                rss_input: $('.js-input-rss'),
                rss_link: $('.js-btn-rss-link'),
                btn_add_type: $('#modal-add-type .save-type'),

                user_types: window.USER_TYPES,
                container_types: $('.js-types-container'),
                events: {
                    click: {
                        '#colorblind-mode': funcOptionsUpdate,
                        '#hide-released': funcOptionsUpdate,
                        '#hide-tba': funcOptionsUpdate,
                        '#private-profile': funcOptionsUpdate,
                        '.js-btn-change-rss': function(e) {
                            e.preventDefault();

                            // save a reference, since e will be null in ajax cb
                            let btn = e.currentTarget;
                            if (btn.classList.contains('is-loading')) { return; }
                            btn.classList.add('is-loading');

                            api.get(
                                '/api/v1/options/refresh/rss',
                                function(a) {  // success callback
                                    if (!a.data.error) {
                                        window.options.setRSS(a.data.data);
                                    } else {
                                        console.error(a.data.message);
                                    }
                                    btn.classList.remove('is-loading');
                                },
                                function(a) {  // error callback
                                    btn.classList.remove('is-loading');
                                }
                            );
                        },
                    }
                },
                typeChangeCB: function(changedEl, cb) {
                    let parentRow = changedEl.closest('.type-item');
                    let data = {
                        id: +parentRow.getAttribute('data-id'),
                        sort: +parentRow.getAttribute('data-sort'),
                    };
                    parentRow.querySelectorAll('.js-type-changeable').forEach(function(el) {
                        data[el.getAttribute('data-key')] = el.value;
                    });

                    api.put(
                        '/api/v1/options/type',
                        data,
                        function(json) {
                            if (!json.data.error) {
                                // Update the element inside the global array
                                USER_TYPES[data.sort] = json.data.data;
                                try {
                                    // Re-render all optins in select
                                    window.modalAdd.renderSelectOptions();
                                    // update idents
                                    let option = window.modalAdd.getSelectedTypeOption();
                                    window.modalAdd.setIdent1Title(option.getAttribute('data-ident1'));
                                    window.modalAdd.setIdent2Title(option.getAttribute('data-ident2'));
                                } catch (e) {
                                    // when error happens, the error callback is invoked -> we're in a broken state
                                    location.reload();
                                }

                                notify('Success!', 'Type was updated', 'success');
                            } else {
                                notify('Error!', 'Could not change type', 'danger');
                            }
                            cb();
                        },  // success callback
                        function(a) {
                            notify('Error!', 'Could not change type', 'danger');
                            cb();
                        }  // error callback
                    );
                },
                typeMoveCB: function(clickedEl, cb) {
                    let parentRow = clickedEl.closest('.type-item');
                    let currentPos = +parentRow.getAttribute('data-sort');
                    let moveDirection = clickedEl.getAttribute('data-interact') === 'up' ? -1 : 1;

                    let data = [];
                    for (let i = 0; i < USER_TYPES.length; ++i) {
                        data[i] = { id: USER_TYPES[i].id, pos: i };
                    }

                    // Now update the current position with desired new one and switch places with the other element
                    data[currentPos].pos = data[currentPos].pos + moveDirection;
                    data[currentPos + moveDirection].pos += -moveDirection;

                    api.put(
                        '/api/v1/options/type-order',
                        { types: data },
                        function(json) {
                            if (!json.data.error) {
                                let oldPosition = Object.assign({}, USER_TYPES[currentPos + moveDirection]);
                                    oldPosition.sort = currentPos;
                                USER_TYPES[currentPos + moveDirection] = Object.assign({}, USER_TYPES[currentPos]);
                                USER_TYPES[currentPos + moveDirection].sort = currentPos + moveDirection;
                                USER_TYPES[currentPos] = oldPosition;

                                notify('Saved!', 'Type order was changed', 'success');
                            } else {
                                notify('Failed!', 'Type order could not be changed', 'danger');
                            }
                            cb();
                        },  // success callback
                        function(a) {
                            notify('Error!', 'Type order was not changed', 'success');
                            cb();
                        }  // error callback
                    );
                },
                typeRemoveCB: function(clickedEl, cb) {
                    if (confirm('Do you really want to delete this type?')) {
                        let parentRow = clickedEl.closest('.type-item');
                        let id = +parentRow.getAttribute('data-id');
                        let position = parentRow.getAttribute('data-sort');

                        // Sort order must be updated as well
                        let data = [];
                        for (let i = 0; i < USER_TYPES.length; ++i) {
                            if (USER_TYPES[i].id === id) { continue; }  //skip the to be removed type
                            data.push({ id: USER_TYPES[i].id, pos: data.length });
                        }

                        api.delete(
                            '/api/v1/options/type',
                            { id: id, types: data },
                            function(json) {
                                if (!json.data.error) {
                                    USER_TYPES.splice(position, 1);
                                    // update sort index or re-ordering will break due to unknown index
                                    USER_TYPES.forEach((el, i) => {
                                        USER_TYPES[i].sort = i;
                                    });

    
                                    notify('Removed!', 'Your type was removed', 'success');
                                } else {
                                    notify('Failed!', json.data.message, 'danger');
                                }
                                cb();
                            },  // success callback
                            function(a) {
                                notify('Error!', 'Could not remove type', 'danger');
                                cb();
                            }  // error callback
                        );
                    }
                },
                typeAddCB: function(btn, cb) {
                    let modalAddType = $('#modal-add-type');
                    let btnSaveType = $('.save-type', modalAddType);
                    if (btnSaveType.classList.contains('is-loading')) { return; }
                    
                    let abort = false;
                    let selectDisplay = $('.js-type-display', modalAddType);
                    let inputName = $('.js-new-type-name', modalAddType);
                    if (inputName.value.length === 0) {
                        inputName.classList.add('is-danger');
                        abort = true;
                    } else {
                        inputName.classList.remove('is-danger');
                    }
                    let desc1 = $('.js-new-type-descriptor1', modalAddType);
                    if (desc1.value.length === 0) {
                        desc1.classList.add('is-danger');
                        abort = true;
                    } else {
                        desc1.classList.remove('is-danger');
                    }
                    let desc2 = $('.js-new-type-descriptor2', modalAddType);
                    if (desc2.value.length === 0) {
                        desc2.classList.add('is-danger');
                        abort = true;
                    } else {
                        desc2.classList.remove('is-danger');
                    }

                    if (abort) {
                        return cb(false);
                    }

                    let data = {
                        display: selectDisplay ? selectDisplay.selectedIndex + 1 : 1,  // default is 1: list
                        name: inputName.value,
                        ident_1: desc1.value,
                        ident_2: desc2.value,
                        sort: ($$('.js-types-container .type-item').length || 0)
                    };

                    btnSaveType.classList.add('is-loading');
                    api.post(
                        '/api/v1/options/save-type',
                        data,
                        function(json) {
                            if (!json.data.error) {
                                modalAddType.classList.remove('is-active');
                                btnSaveType.classList.remove('is-loading');

                                // Update the element inside the global array
                                data.id = json.data.data;
                                USER_TYPES.push(data);

                                if (USER_TYPES.length === 1) {
                                    try {
                                        // Re-render all optins in select
                                        window.modalAdd.renderSelectOptions();
                                        // update idents
                                        window.modalAdd.setIdent1Title(data.ident_1);
                                        window.modalAdd.setIdent2Title(data.ident_2);
                                    } catch (e) {
                                        // when error happens, the error callback is invoked -> we're in a broken state
                                        location.reload();
                                    }
                                }

                                // Restore default state
                                selectDisplay.selectedIndex = 1;
                                inputName.value = '';
                                desc1.value = '';
                                desc2.value = '';

                                notify('Saved!', 'Your new type is available now', 'success');
                            } else {
                                notify('Failed!', json.data.message, 'danger');
                            }
                            cb();
                        },  // success callback
                        function(a) {
                            notify('Error!', 'Could not save your settings', 'danger');
                            btnSaveType.classList.remove('is-loading');
                            cb(false);  // resets ajaxInProgress var but does not re-render html
                        }  // error callback
                    );
                }
            });
        }

        let bindEntryEvents = function() {
            if (!isUser) { return; }

            // Changing Entry visibility
            let iconCurrentVisibility = $$('.current-visibility');
            for (let i = 0; i < iconCurrentVisibility.length; ++i) {
                iconCurrentVisibility[i].addEventListener('click', function(e) { e.preventDefault(); });
    
                let btnChange = $$('.dropdown-menu .dropdown-item a', iconCurrentVisibility[i].parentNode.parentNode);
                for (let j = 0; j < btnChange.length; ++j) {
                    btnChange[j].addEventListener('click', function(e) {
                        e.preventDefault();
                        // the "parent" visibility icon will have the class, since for each option that's the same
                        if (iconCurrentVisibility[i].classList.contains('is-loading')) { return; }
                        if (iconCurrentVisibility[i].classList.contains(this.className)) { return; }
                        iconCurrentVisibility[i].classList.add('is-loading');
    
                        let id = this.getAttribute('data-id');
                        let visibility = this.getAttribute('data-visibility');
                        if (id === null || visibility === null) { return; }
    
                        let _this = this;
                        api.post(
                            '/api/v1/entry/change-visibility',
                            { id: id, visibility: visibility },
                            function(json) {
                                if (!json.data.error) {
                                    let mapVisibility = {
                                        'v-is-hidden': 'Only visible on the website when logged in',
                                        'v-is-private': 'Visible on the website when logged in and RSS',
                                        'v-is-public': 'Visible everywhere'
                                    };

                                    iconCurrentVisibility[i].classList.remove('v-is-hidden', 'v-is-private', 'v-is-public');
                                    iconCurrentVisibility[i].classList.add(_this.className);
                                    iconCurrentVisibility[i].setAttribute('title', mapVisibility[_this.className]);

                                    let map = {
                                        'v-is-hidden': 'hidden',
                                        'v-is-private': 'private',
                                        'v-is-public': 'public',
                                    };

                                    // Update the visibility change.
                                    // Since that is inline and not inside the modal we need to update the state here
                                    let entry = getEntryById(id);
                                    if (entry) {
                                        entry.setVisibility(visibility);
                                    }
                                    notify('Saved!', 'Visibility was changed to ' + map[_this.className], 'success');
                                } else {
                                    notify('Error!', 'Could not change visibility1', 'danger');
                                }
                                iconCurrentVisibility[i].classList.remove('is-loading')
                            },  // success callback
                            function(json) {
                                iconCurrentVisibility[i].classList.remove('is-loading')
                                notify('Error!', 'Could not change visibility2', 'danger');
                            }  // error callback
                        );
                    });
                }
            }

            // Remove Entry button
            let removeEntry = $$('.remove-entry');
            for (let i = 0; i < removeEntry.length; ++i) {
                removeEntry[i].addEventListener('click', function(e) {
                    e.preventDefault();
                    $('#modal-remove-entry').classList.add('is-active');

                    let id = this.getAttribute('data-id');
                    let entry = getEntryById(id);

                    let mre = $('#modal-remove-entry');
                    $('.entry-ident1', mre).innerHTML = entry.getIdent1();
                    $('.entry-ident2', mre).innerHTML = entry.getIdent2();

                    let _date = entry.getReleaseAt() === null ? 'TBA' : new Date(entry.getReleaseAt());
                    let dateHumanReadable = _date;
                    if (_date !== 'TBA') {
                        dateHumanReadable = _date.toGMTString();
                        let res = dateHumanReadable.match(new RegExp(".+?,.+? [0-9]{4}"));
                        dateHumanReadable = res[0];
                    }
                    $('.entry-release-at', mre).innerHTML = dateHumanReadable;
                    $('.remove-modal', mre).setAttribute('data-id', id);
                });
            }

            // Edit Entry button
            // Defining click events on edit buttons
            let editEntry = $$('.edit-entry');
            for (let i = 0; i < editEntry.length; ++i) {
                editEntry[i].addEventListener('click', function(e) {
                    e.preventDefault();

                    let id = this.getAttribute('data-id');
                    let entry = getEntryById(id);

                    window.modalEdit.open({
                        EntryId: id,
                        SelectedTypeOption: entry.parent().getId(),
                        Ident1Title: entry.parent().getIdent1(),
                        Ident1Input: entry.getIdent1(),
                        Ident2Title: entry.parent().getIdent2(),
                        Ident2Input: entry.getIdent2(),
                        ReleaseInput: entry.getReleaseAt(),
                        Visibility: entry.getVisibility()
                    });
                });
                let tr = editEntry[i].parentNode.parentNode;
                let entry = editEntry[i];
                tr.addEventListener('dblclick', function() {
                    entry.click();
                });
            }

            // Setting table sort by header click
            let tableSortHeader = $$('.js-sortable');
            tableSortHeader.forEach(function(head, i) {
                head.addEventListener('click', function(e) {
                    let clickedType = undefined;
                    let typeId = +e.currentTarget.getAttribute('data-type');
                    window.TYPES.some(function(type) {
                        if (type.getId() === typeId) {
                            clickedType = type;
                            return true;
                        }
                        return false;
                    });

                    if (e.currentTarget.classList.contains('sort-active')) {
                        clickedType.sort(clickedType.config.sortBy);
                    } else {
                        // remove the active state from all header
                        tableSortHeader.forEach(function(head2) {
                            head2.classList.remove('sort-active');
                        });
                        // set active state on the clicked column
                        e.currentTarget.classList.add('sort-active');
                        clickedType.sort(e.currentTarget.getAttribute('data-property'));
                    }
                    window.TYPES.forEach(function(e, i) { e.renderHTML($('.container-entries'), i < 1) });
                    bindEntryEvents();
                });
            });
        };

        // Confirmation modal for removing an entry
        let btnRemoveEntry = $('#modal-remove-entry .remove-modal');
        if (btnRemoveEntry) {
            btnRemoveEntry.addEventListener('click', function(e) {
                if (this.classList.contains('is-loading')) { return; }
                this.classList.add('is-loading');

                let id = this.getAttribute('data-id');
                let _thisModal = this;
                api.post(
                    '/api/v1/entry/remove',
                    { id: id },
                    function(json) {
                        if (!json.data.error) {
                            let entry = getEntryById(id);
                                entry.delete();

                            // Update list display
                            window.TYPES.forEach(function(e, i) { e.renderHTML($('.container-entries'), i < 1) });
                            bindEntryEvents();

                            _thisModal.setAttribute('data-id', 0);
                            $('#modal-remove-entry').classList.remove('is-active');
                            notify('Removed!', 'Entry was removed', 'success');
                        } else {
                            notify('Failed!', json.data.message, 'danger');
                        }
                        _thisModal.classList.remove('is-loading');
                    },  // success callback
                    function(a) {
                        _thisModal.classList.remove('is-loading');
                        notify('Error!', 'Could not remove entry', 'danger');
                    }  // error callback
                );

            });
        }

        bindEntryEvents();
    }
})();