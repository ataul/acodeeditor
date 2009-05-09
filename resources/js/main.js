Ext.onReady(function(){

	var Filemenu = new Ext.menu.Menu({
		items: [
		{
			text: 'New',
			handler: function(){
				document.getElementById('editor').innerHTML = '<textarea id="code" rows="10" col="20" class="codepress php" style="width:900px;height:500px;">';	
				CodePress.run();
			}
		}]
	});
	
	var Languagemenu = new Ext.menu.Menu({
		items: [
			{
				text: 'PHP',
				handler: function(){
					code.edit('','php');	
				}
			},
			{
				text: 'Java',
				handler: function(){
					code.edit('','java');
				}
			},
			{
				text: 'Javascript',
				handler: function(){
					code.edit('','javascript');
				}
			},
			{
				text: 'HTML',
				handler: function(){
					code.edit('','html');
				}
			}
		]
	});
	
	var Viewmenu = new Ext.menu.Menu({
		items: [
		{
			text: 'Toggle line no',
			handler: function(){
				code.toggleLineNumbers();			
			}
		}]
	});
	
	var Helpmenu = new Ext.menu.Menu({
		items: [
		{
			text: 'About',
			handler: function(){
				Ext.Msg.alert('ACodeEditor v0.4');
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
                    margins:'0 0 0 5',
					contentEl:'editor'                 
                    }
					
				]             
        });		
		
    });