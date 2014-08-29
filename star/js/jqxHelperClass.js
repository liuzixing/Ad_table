function jqxHelperClass() {
    var self = this;
    this.globaltheme = 'bootstrap';
    this.getDropDownListItems = function(id) {
        var items = $("#" + id).jqxDropDownList('getCheckedItems');
        var res = [];
        for (var i = 0; i < items.length; i++) {
            res.push(items[i].label);
        };
        //release memory
        items = null;
        return res;
    }

    this.getDropDownListItem = function(id) {
        return $("#" + id).jqxDropDownList('getSelectedItem').label;
    }

    this.getDateTimeInputRange = function(id) {
        var selection = $("#" + id).jqxDateTimeInput('getRange');
        if (selection != null) {
            return {
                "from": selection.from.toLocaleDateString(),
                "to": selection.to.toLocaleDateString()
            };
        } else {
            return {};
        }
    }

    // this.initialDropDownList = function(id, placeHolder, checkboxed,) {
    //     $("#valueselector3").jqxDropDownList({
    //         theme: self.globaltheme,
    //         source: source,
    //         placeHolder: "3ème valeur à afficher",
    //         width: '90%',
    //         height: '25'
    //     });
    // }
}