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
            //console.log();
            return {
                "from": self.getDateFormat(selection.from),
                "to": self.getDateFormat(selection.to)
            };
        } else {
            return {};
        }
    }
    this.getDateTimeInput = function(id) {
        var selection = $("#" + id).jqxDateTimeInput('getRange');
        if (selection != null) {
            return {
                "from": self.getDateFormat(selection.from),
                "to": self.getDateFormat(selection.to)
            };
        } else {
            return {};
        }
    }
    this.getSeperatedNumber = function(number, splitter) {
        var res = number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, splitter);
        // if (res[res.length - 1 ] == " "){
        //     res = res.substring(0, res.length - 1);
        // }
        return res;
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