/**
 * French translation for bootstrap-year-calendar
 * Paul DAVID-SIVELLE
 * Based on 
 * French translation for bootstrap-datepicker
 * Nico Mollet <nico.mollet@gmail.com>
 */
 
;(function calendar($){
	$.fn.calendar.dates['fr'] = {
		days: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"],
		daysShort: ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim"],
		daysMin: ["D", "L", "Ma", "Me", "J", "V", "S", "D"],
		months: ["Janvier", "FÃ©vrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "AoÃ»t", "Septembre", "Octobre", "Novembre", "DÃ©cembre"],
		monthsShort: ["Jan", "FÃ©v", "Mar", "Avr", "Mai", "Jui", "Jul", "Aou", "Sep", "Oct", "Nov", "DÃ©c"],
		weekShort:'S',
		weekStart: 1
	};
}(jQuery));

Calendar.prototype =
{
    constructor: Calendar,
    _initializeOptions: function(opt) 
    {
        if(opt == null) 
        {
            opt = [];
        }
    
        this.options = 
        {
            startYear: !isNaN(parseInt(opt.startYear)) ? parseInt(opt.startYear) : new Date().getFullYear(),
            minDate: opt.minDate instanceof Date ? opt.minDate : null,
            maxDate: opt.maxDate instanceof Date ? opt.maxDate : null,
            language: (opt.language != null && dates[opt.language] != null) ? opt.language : 'en',
            allowOverlap: opt.allowOverlap != null ? opt.allowOverlap : true,
            displayWeekNumber: opt.displayWeekNumber != null ? opt.displayWeekNumber : false,
            displayDisabledDataSource: opt.displayDisabledDataSource != null ? opt.displayDisabledDataSource : false,
            displayHeader: opt.displayHeader != null ? opt.displayHeader : true,
            alwaysHalfDay: opt.alwaysHalfDay != null ? opt.alwaysHalfDay : false,
            enableRangeSelection: opt.enableRangeSelection != null ? opt.enableRangeSelection : false,
            disabledDays: opt.disabledDays instanceof Array ? opt.disabledDays : [],
            disabledWeekDays: opt.disabledWeekDays instanceof Array ? opt.disabledWeekDays : [],
            hiddenWeekDays: opt.hiddenWeekDays instanceof Array ? opt.hiddenWeekDays : [],
            roundRangeLimits: opt.roundRangeLimits != null ? opt.roundRangeLimits : false,
            dataSource: opt.dataSource instanceof Array ? opt.dataSource : [],
            style: opt.style == 'background' || opt.style == 'border' || opt.style == 'custom' ? opt.style : 'border',
            enableContextMenu: opt.enableContextMenu != null ? opt.enableContextMenu : false,
            contextMenuItems: opt.contextMenuItems instanceof Array ? opt.contextMenuItems : [],
            customDayRenderer : $.isFunction(opt.customDayRenderer) ? opt.customDayRenderer : null,
            customDataSourceRenderer : $.isFunction(opt.customDataSourceRenderer) ? opt.customDataSourceRenderer : null,
            weekStart: !isNaN(parseInt(opt.weekStart)) ? parseInt(opt.weekStart) : null
        };
        this._initializeDatasourceColors();
	},
        _initializeEvents: function(opt) 
        {
            if(opt == null) 
            {
				opt = [];
            }
        }

}
        

$('.calendar').calendar();

function editEvent(event) {
    $('#event-modal input[name="event-index"]').val(event ? event.id : ''); 
    $('#event-modal input[name="event-name "]').val(event ? event.name : '');
    $('#event-modal input[name="event-location"]').val(event ? event.location : '');
    $('#event-modal input[name="event-start-date"]').datepicker('update', event ? event.startDate : '');
    $('#event-modal input[name="event-end-date"]').datepicker('update', event ? event.endDate : '');
    $('#event-modal').modal();
}

function deleteEvent(event) {
    var dataSource = $('#calendar').data('calendar').getDataSource();

    for(var i in dataSource) {
        if(dataSource[i].id == event.id) {
            dataSource.splice(i, 1);
            break;
        }
    }
    
    $('#calendar').data('calendar').setDataSource(dataSource);
}

function saveEvent() {
    var event = {
        id: $('#event-modal input[name="event-index"]').val(),
        name: $('#event-modal input[name="event-name"]').val(),
        location: $('#event-modal input[name="event-location"]').val(),
        startDate: $('#event-modal input[name="event-start-date"]').datepicker('getDate'),
        endDate: $('#event-modal input[name="event-end-date"]').datepicker('getDate')
    }
    
    var dataSource = $('#calendar').data('calendar').getDataSource();

    if(event.id) {
        for(var i in dataSource) {
            if(dataSource[i].id == event.id) {
                dataSource[i].name = event.name;
                dataSource[i].location = event.location;
                dataSource[i].startDate = event.startDate;
                dataSource[i].endDate = event.endDate;
            }
        }
    }
    else
    {
        var newId = 0;
        for(var i in dataSource) {
            if(dataSource[i].id > newId) {
                newId = dataSource[i].id;
            }
        }
        
        newId++;
        event.id = newId;
    
        dataSource.push(event);
    }
    
    $('#calendar').data('calendar').setDataSource(dataSource);
    $('#event-modal').modal('hide');
}

$(function() {
    var currentYear = new Date().getFullYear();

    $('#calendar').calendar({ 
        enableContextMenu: true,
        enableRangeSelection: true,
        contextMenuItems:[
            {
                text: 'Update',
                click: editEvent
            },
            {
                text: 'Delete',
                click: deleteEvent
            }
        ],
        selectRange: function(e) {
            editEvent({ startDate: e.startDate, endDate: e.endDate });
        },
        mouseOnDay: function(e) {
            if(e.events.length > 0) {
                var content = '';
                
                for(var i in e.events) {
                    content += '<div class="event-tooltip-content">'
                                    + '<div class="event-name" style="color:' + e.events[i].color + '">' + e.events[i].name + '</div>'
                                    + '<div class="event-location">' + e.events[i].location + '</div>'
                                + '</div>';
                }
            
                $(e.element).popover({ 
                    trigger: 'manual',
                    container: 'body',
                    html:true,
                    content: content
                });
                
                $(e.element).popover('show');
            }
        },
        mouseOutDay: function(e) {
            if(e.events.length > 0) {
                $(e.element).popover('hide');
            }
        },
        dayContextMenu: function(e) {
            $(e.element).popover('hide');
        },
        dataSource: [
            {
                id: 0,
                name: 'Google I/O',
                location: 'San Francisco, CA',
                startDate: new Date(currentYear, 4, 28),
                endDate: new Date(currentYear, 4, 29)
            },
            {
                id: 1,
                name: 'Microsoft Convergence',
                location: 'New Orleans, LA',
                startDate: new Date(currentYear, 2, 16),
                endDate: new Date(currentYear, 2, 19)
            },
            {
                id: 2,
                name: 'Microsoft Build Developer Conference',
                location: 'San Francisco, CA',
                startDate: new Date(currentYear, 3, 29),
                endDate: new Date(currentYear, 4, 1)
            },
            {
                id: 3,
                name: 'Apple Special Event',
                location: 'San Francisco, CA',
                startDate: new Date(currentYear, 8, 1),
                endDate: new Date(currentYear, 8, 1)
            },
            {
                id: 4,
                name: 'Apple Keynote',
                location: 'San Francisco, CA',
                startDate: new Date(currentYear, 8, 9),
                endDate: new Date(currentYear, 8, 9)
            },
            {
                id: 5,
                name: 'Chrome Developer Summit',
                location: 'Mountain View, CA',
                startDate: new Date(currentYear, 10, 17),
                endDate: new Date(currentYear, 10, 18)
            },
            {
                id: 6,
                name: 'F8 2015',
                location: 'San Francisco, CA',
                startDate: new Date(currentYear, 2, 25),
                endDate: new Date(currentYear, 2, 26)
            },
            {
                id: 7,
                name: 'Yahoo Mobile Developer Conference',
                location: 'New York',
                startDate: new Date(currentYear, 7, 25),
                endDate: new Date(currentYear, 7, 26)
            },
            {
                id: 8,
                name: 'Android Developer Conference',
                location: 'Santa Clara, CA',
                startDate: new Date(currentYear, 11, 1),
                endDate: new Date(currentYear, 11, 4)
            },
            {
                id: 9,
                name: 'LA Tech Summit',
                location: 'Los Angeles, CA',
                startDate: new Date(currentYear, 10, 17),
                endDate: new Date(currentYear, 10, 17)
            }
        ]
    });
    
    $('#save-event').click(function() {
        saveEvent();
    });
});