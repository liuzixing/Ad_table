function jqxHelperClass() {
    var self = this;
    this.globaltheme = 'bootstrap';
    this.checkboxesAvailable = {};
    this.getDropDownListItems = function(id) {
        var items = $("#" + id).jqxDropDownList('getCheckedItems');
        var res = [];
        for (var i = 0; i < items.length; i++) {
            if (items[i].label == "Tout sélectionner") {
                continue;
            }
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
        return res;
    }

    this.initialSideBarDropDownList = function(id, source, checkboxes) {
        var jqObject = $("#" + id);
        if (checkboxes) {
            jqObject.jqxDropDownList({
                theme: self.globaltheme,
                source: ["Tout sélectionner"].concat(source),
                checkboxes: checkboxes,
                placeHolder: id,
                width: '90%',
                height: '25'
            });
            jqObject.jqxDropDownList('checkAll');
            self.selectAllEvent(id);
        } else {
            jqObject.jqxDropDownList({
                theme: self.globaltheme,
                source: source,
                checkboxes: checkboxes,
                placeHolder: "Choix "+id,
                width: '90%',
                height: '25'
            });
        }
    }
    this.selectAllEvent = function(id) {
        var jqObject = $("#" + id);
        self.checkboxesAvailable[id] = true;
        jqObject.on('checkChange', function(event) {
            if (!self.checkboxesAvailable[event.currentTarget.id])
                return;
            if (event.args.value != "Tout sélectionner") {
                self.checkboxesAvailable[event.currentTarget.id] = false;
                jqObject.jqxDropDownList('checkIndex', 0);
                var checkedItems = jqObject.jqxDropDownList('getCheckedItems'),
                    items = jqObject.jqxDropDownList('getItems');
                if (checkedItems.length == 1) {
                    jqObject.jqxDropDownList('uncheckIndex', 0);
                } else if (items.length != checkedItems.length) {
                    jqObject.jqxDropDownList('indeterminateIndex', 0);
                }
                self.checkboxesAvailable[event.currentTarget.id] = true;
            } else {
                self.checkboxesAvailable[event.currentTarget.id] = false;
                if (event.args.checked) {
                    jqObject.jqxDropDownList('checkAll');
                } else {
                    jqObject.jqxDropDownList('uncheckAll');
                }
                self.checkboxesAvailable[event.currentTarget.id] = true;
            }
        });
    }
    this.initialSideBarRangeDatePicker = function(id, disabled, from, to) {
        $("#" + id).jqxDateTimeInput({
            theme: self.globaltheme,
            width: '90%',
            height: '25px',
            disabled: disabled,
            selectionMode: 'range'
        });
        if (from) {
            $("#" + id).jqxDateTimeInput({
                min: from,
                max: to,
            });
        }
    }
}