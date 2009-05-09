Ext.onReady(function(){

	var Filemenu = new Ext.menu.Menu({
		items: [
		{
			text: 'New',
			handler: function(){
				
			}
		}]
	});
	
	var Languagemenu = new Ext.menu.Menu({
		items: [
			{
				text: 'PHP',
				handler: function(){
					
				}
			},
			{
				text: 'Java',
				handler: function(){
					
				}
			},
			{
				text: 'Javascript',
				handler: function(){
					
				}
			},
			{
				text: 'HTML',
				handler: function(){
					
				}
			}
		]
	});
	
	var Viewmenu = new Ext.menu.Menu({
		items: [
		{
			text: 'Toggle line no',
			handler: function(){
				
			}
		}]
	});
	
	var Helpmenu = new Ext.menu.Menu({
		items: [
		{
			text: 'About',
			handler: function(){
				alert('ACodeEditor v0.4');
			}
		}]
	});

	var tb = new Ext.Toolbar();
	
	tb.add(
		{
            text:'File',            
            menu: Filemenu  
        },
		{
            text:'View',            
            menu: Viewmenu  
        },
		{
            text:'Language',            
            menu: Languagemenu  
        },
		{
            text:'Help',            
            menu: Helpmenu  
        }
	);
	
    tb.render('toolbar');
	
		
	
       var viewport = new Ext.Viewport({
            layout:'border',
            items:[
                new Ext.BoxComponent({ // raw
                    region:'north',
                    el: 'north',
                    height:32
                }),{
                    region:'south',
                    contentEl: 'south'
                }, {
                    region:'east',
                    title: 'Help',
                    collapsible: true,
					collapsed: true,
                    split:true,
                    width: 225,
                    minSize: 175,
                    maxSize: 400,
                    layout:'fit',
                    margins:'0 5 0 0'
                 },{
                    region:'west',
                    id:'west-panel',
					contentEl:'tree-ct',
                    title:'Menu',
                    split:true,
                    width: 200,
                    minSize: 175,
                    maxSize: 400,
                    collapsible: true,
                    margins:'0 0 0 5',
                    layout:'accordion',
                    layoutConfig:{
                        animate:true
                    }
                },
                {
                    region:'center',
					title: 'Editor',
                    contentEl:'center1',
                    split:true,
                    width: 200,
                    minSize: 175,
                    maxSize: 400,
                    //collapsible: true,
                    margins:'0 0 0 5'
                    
                    }
					
				]             
        });		
		
    });