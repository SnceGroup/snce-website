// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: eZ Image Editor extension for eZ Publish
// SOFTWARE RELEASE: 5.2.0
// COPYRIGHT NOTICE: Copyright (C) 1999-2013 eZ Systems AS
// SOFTWARE LICENSE: eZ Business Use License Agreement eZ BUL Version 2.1
// NOTICE: >
//   This source file is part of the eZ Publish CMS and is
//   licensed under the terms and conditions of the eZ Business Use
//   License v2.1 (eZ BUL).
// 
//   A copy of the eZ BUL was included with the software. If the
//   license is missing, request a copy of the license via email
//   at license@ez.no or via postal mail at
//  	Attn: Licensing Dept. eZ Systems AS, Klostergata 30, N-3732 Skien, Norway
// 
//   IMPORTANT: THE SOFTWARE IS LICENSED, NOT SOLD. ADDITIONALLY, THE
//   SOFTWARE IS LICENSED "AS IS," WITHOUT ANY WARRANTIES WHATSOEVER.
//   READ THE eZ BUL BEFORE USING, INSTALLING OR MODIFYING THE SOFTWARE.

// ## END COPYRIGHT, LICENSE AND WARRANTY NOTICE ##

ezie.gui.selection_impl = function() {
    var selection = {
        x: 0,
        y: 0,
        w: 0,
        h: 0
    };

    var active = false;

    var isSelectionActive = function () {
        return active;
    };

    var removeSelection = function() {
        selection.x = 0;
        selection.y = 0;
        selection.w = 0;
        selection.h = 0;

        deactivate();
    }

    var setSelection = function (c) {
        selection.x = c.x;
        selection.y = c.y;
        selection.w = c.w;
        selection.h = c.h;

        if (c.w == 0 || c.h == 0) {
            deactivate()
        } else {
            activate();
        }

    //$.log('[selection] (x, y) : (' + selection.x + ',  ' + selection.y + ') - (w, h)' + '(' + selection.w + ', ' + selection.h + ')');
    };

    var deactivate = function () {
        active = false;
    }

    var activate = function() {
        active = true;
    }

    var hasSelection = function() {
        return (selection.w != 0 && selection.h != 0);
    }

    var getSelection = function() {
        return selection;
    };

    var getZoomedSelection = function(zoom) {
        zoom = zoom / 100;
        $.log('[zoomed selection] '+
            '(x, y) : (' + (selection.x * zoom) + ',  ' + (selection.y * zoom) + ') '+
            '- (w, h)' + '(' + (selection.w * zoom) + ', ' + (selection.h * zoom) + ')');

        return {
            x: (selection.x * zoom),
            y: (selection.y * zoom),
            w: (selection.w * zoom),
            h: (selection.h * zoom)
        };
    };

    var getArrayZoomedSelection = function(zoom) {
        select = getZoomedSelection(zoom);

        return {
            'selection[x]': select.x,
            'selection[y]': select.y,
            'selection[w]': select.w,
            'selection[h]': select.h
        };
    }

    var getArraySelection = function() {
        select = getSelection();
        var res = [];
        res['x'] = select.x;
        res['y'] = select.y;
        res['w'] = select.w;
        res['h'] = select.h;
        return res;
    }

    return {
        isSelectionActive:isSelectionActive,
        hasSelection:hasSelection,
        remove:removeSelection,
        selection:getSelection,
        set:setSelection,
        zoomedSelection:getZoomedSelection,
        arrayZoomedSelection:getArrayZoomedSelection,
        arraySelection: getArraySelection,
        deactivate:deactivate
    };
}

ezie.gui.selection_instance = null;
ezie.gui.selection = function() {
    if (ezie.gui.selection_instance == null) {
        ezie.gui.selection_instance = new ezie.gui.selection_impl();
    }

    return ezie.gui.selection_instance;
};
