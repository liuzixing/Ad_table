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
    this.getDateFormat = function(d) {
        var curr_date = d.getDate();
        var curr_month = d.getMonth() + 1; //Months are zero based
        var curr_year = d.getFullYear();
        if (curr_date < 10) {
            curr_date = "0" + curr_date;
        }
        if (curr_month < 10) {
            curr_month = "0" + curr_month;
        }
        return curr_date + "/" + curr_month + "/" + curr_year;
    }
    this.getDateTimeInputRange = function(id) {
        var selection = $("#" + id).jqxDateTimeInput('getRange');
        if (selection != null) {
            //var d = selection.from;
            //console.log();
            return {
                "from": self.getDateFormat(selection.from),
                "to": self.getDateFormat(selection.to)
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