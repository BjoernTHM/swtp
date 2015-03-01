var chat = Ext.create('Ext.field.TextArea', {});
var input = Ext.create('Ext.field.Text', {
    placeHolder: 'Type your answer'
});
chat.disable();

var name = "anonymous";

Ext.Ajax.request({
    url: './',
    method: "POST",
    params: 'action=login',
    success: function(response) {
        name += response.responseText;
    }
});

setInterval(function() {
    Ext.Ajax.request({
        url: './',
        method: "POST",
        params: 'action=pull&user=' + name,
        success: function(response) {
            if (response.responseText.length > 0) 
                chat.setValue(response.responseText);
        }
    });
}, 500);

input.on("keyup", function(obj, e) {
    if (e.browserEvent.keyCode == 13) {
        Ext.Ajax.request({
            url: './',
            method: "POST",
            params: 'action=push&user=' + name + '&value=' + input.getValue(),
            success: function(response) {
                if (response.responseText.length > 0) 
                    chat.setValue(response.responseText);
            }
        });
        input.setValue("");
    }
});

Ext.define('sencha.view.Main', {
    extend: 'Ext.tab.Panel',
    xtype: 'main',
    requires: [
        'Ext.TitleBar'
    ],
    config: {
        tabBarPosition: 'bottom',

        items: [
            {
                title: 'Chat',
                iconCls: 'compose',

                styleHtmlContent: true,
                scrollable: true,

                items: [{
                    docked: 'top',
                    xtype: 'titlebar',
                    title: 'Welcome to my \'Hello World!\'-Chat'
                }, 
                chat,
                input
                ],
            }
        ]
    }
});
