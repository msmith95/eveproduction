/*!
 * Sections of code from https://github.com/jimpurbrick/crestexplorerjs
 *  Copyright 2012, CCP (http://www.ccpgames.com)
 *  Dual licensed under the MIT or GPL Version 2 licenses.
 *  http://www.opensource.org/licenses/mit-license.php
 *  http://www.opensource.org/licenses/GPL-2.0
 *
 *  All other code is under the MIT license.
 *
*/


var endpoints;
var regions=Array();
var marketGroups;
var currentRegion;
var currentGroup;
var searchObj=Array();
var itemPage=Array();
var presetRegion;
var presetTypeid=0;
var arr = Array();
var prices = Array();
var corpToLoad;
var groupsList = ["https://public-crest.eveonline.com/market/groups/4/", "https://public-crest.eveonline.com/market/groups/9/", "https://public-crest.eveonline.com/market/groups/11/", "https://public-crest.eveonline.com/market/groups/157/", "https://public-crest.eveonline.com/market/groups/475/", "https://public-crest.eveonline.com/market/groups/477/", "https://public-crest.eveonline.com/market/groups/955/"];

//(function ($, window, document) {

$.urlParam = function(name){
    var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null){
       return null;
   }
   else{
          return results[1] || 0;
  }
}
    "use strict";

    // Configuration parameters
    var baseURL = "https://public-crest.eveonline.com";




    // Show error message in main data pane.
    function displayError(error) {
        $("#data").children().replaceWith("<span>" + error + "</span>");
    }

    function getBps(){
        console.log(corpToLoad);
        $.post("backend/test.php", {corp: corpToLoad}, function(result){
                    var json = $.parseJSON(result);
                    console.log(json);
                    //arr = Object.keys(json.typeIds).map(function(k) { return json[k] });
                    arr = json.typeIds;
                    prices = json.prices;
                    console.log(arr.length);
                    console.log(arr.indexOf("23916"))
                    loadMarketGroups();
                });
    }

    function loadEndpoints(corp) {
        console.log(corp);
        corpToLoad = corp;
        $.getJSON(baseURL,function(data,status,xhr) {
            window.endpoints=data;
            getBps();
        });

    }


    function loadMarketGroups() {
        $.getJSON(window.endpoints["marketGroups"].href,function(data,status,xhr) {
            marketGroups=data.items;
            //console.log(marketGroups);
            $.map(marketGroups,function(group){
                //console.log($(group.parentGroup).prop('href'));
                //if($(group.parentGroup).prop('href') == null ){console.log(group);}
                if (/*$(group.parentGroup).prop('href') === 'https://public-crest.eveonline.com/market/groups/2/'*/groupsList.indexOf($(group).prop('href')) >= 0) {
                    $("#marketGroups").append("<li data-cresthref='"+group.href+"' class='groupLink border'>"+group.name+"</li>");
                }
                }
            );
            $('.groupLink').click(function(event){event.stopPropagation();openSubGroup(event.target);/*console.log(event.target.firstChild.data);*/});
            $("#marketgroupmain").show();
        });


    }

    function openSubGroup(group)
    {
        var node;
        var itemcount=0;
        if ($(group).children('ul').length>0) {
            $(group).children('ul').toggle();
        } else {
            $(group).append('<ul class="subdisplay"></ul>');
            node=$(group).children('ul');
            $.map(marketGroups,function(subgroup){
            if (typeof subgroup.parentGroup != 'undefined' && subgroup.parentGroup.href === group.dataset.cresthref) {
                node.append("<li data-cresthref='"+subgroup.href+"' class='groupLink otherBorders'>"+subgroup.name+"</li>");
            }
            if (subgroup.href === group.dataset.cresthref) {
                $.getJSON(subgroup.types.href,function(data,status,xhr) {
                    $.map(data.items,function(item){
                        //console.log(arr.indexOf(item.type.href));
                        //console.log(item.type.href);
                        //console.log(item);
                        //console.log(subgroup);
                        console.log(item);
                        if(arr.indexOf(item.type.id_str) >= 0){
                            if (item.marketGroup.href== group.dataset.cresthref) {

                                node.append("<li data-cresthref='"+item.type.href+"' class='itemLink' typeID='"+ item.type.id_str +"'><img width=25 hieght=25 src='"+item.type.icon.href+"'  data-cresthref='"+item.type.href+"'><span class='itemName'>"+item.type.name+"</span><span class='itemPrice'> Price: " + numeral(prices[item.type.id_str]).format('0,0') + " isk</span> <input type='text' id='"+ item.type.id_str+ "-quantity' name = 'quant' value = '0'></input> <button type='button' onclick='add("+ item.type.id_str + ', \"' + item.type.name + '\"' + ")'>Buy Item</button></li>");
                                itemcount++;
                            }
                        }else{
                            if(item.marketGroup.href== group.dataset.cresthref){
                                node.append("<li class='itemLink' typeID='"+ item.type.id_str +"'><img width=25 hieght=25 src='"+item.type.icon.href+"'  data-cresthref='"+item.type.href+"'><span class='itemName'>"+item.type.name+ "</span><span class='itemPrice'> is not available</span> <button type='button' disabled>Buy Item</button></li>");
                                itemcount++;
                            }
                        }
                    });
                    console.log(itemcount);
                    if (itemcount>0) {
                    console.log('items only');
                     //$('.itemLink').click(function(event){event.stopPropagation();});
                    }
                });
            }
            });
        }
    }

    function openItem(item){
        /*var buytable;
        var selltable;
        $('#MarketDisplay').show();
        buytable=$('#buy').DataTable();
        buytable.rows().remove();
        selltable=$('#sell').DataTable();
        selltable.rows().remove();
        buytable.draw();
        selltable.draw();

        regionname=$("#regionSelector option:selected").text();
        // nasty little hack as the item endpoint doesn't contain the typeid
        typeid=item.dataset.cresthref.replace(baseURL+'/types/','')
        typeid=typeid.replace('/','')


        console.log(item.dataset.cresthref);
        $.getJSON(item.dataset.cresthref,function(data,status,xhr) {
            $('#itemDescription').html(data.name+"<br>"+data.description);
        });
        if (typeof currentRegion != 'undefined') {
            $.getJSON(currentRegion.marketBuyOrders.href+'?type='+item.dataset.cresthref,function(data,status,xhr) {
                $.map(data.items,function(item){
                    buytable.row.add([item.location.name,$.number(item.volume_str),item.minVolume_str,$.number(item.price,2),item.range,moment(item.issued).add(item.duration,'days').format("YYYY-MM-DD HH:mm")]);
                });
                buytable.draw();

            })
            $.getJSON(currentRegion.marketSellOrders.href+'?type='+item.dataset.cresthref,function(data,status,xhr) {
                $.map(data.items,function(item){
                    selltable.row.add([item.location.name,$.number(item.volume_str),$.number(item.price,2),moment(item.issued).add(item.duration,'days').format("YYYY-MM-DD HH:mm")]);
                });
                selltable.draw();
            });
            try {
                 var stateObj = {};
                 history.pushState(stateObj, typeid, "/market/viewer/?typeid="+typeid+"&region="+regionname);
            }
            catch(err) { console.log("No pushstate");}
        } else {
            alert('Set a region to get data');
        }*/

    }

    function getBpsManage(){
        var url = window.location.href.split("?");
        var urlPart2 = url[1].split("=");
        var corp = decodeURIComponent(urlPart2[1]);
        console.log(url + " " + urlPart2 + " " + corp);
        $.post("backend/test.php", {corp: corp}, function(result){
                    var json = $.parseJSON(result);
                    console.log(json);
                    //arr = Object.keys(json).map(function(k) { return json[k] });
                    arr = json.typeIds;
                    prices = json.prices;
                    console.log(arr);
                    console.log(arr.indexOf("23916"));
                    loadMarketGroupsManage();
                });
    }

    function loadEndpointsManage() {
        $.getJSON(baseURL,function(data,status,xhr) {
            window.endpoints=data;
            getBpsManage();
        });
    
    }


    function loadMarketGroupsManage() {
        $.getJSON(window.endpoints["marketGroups"].href,function(data,status,xhr) {
            marketGroups=data.items;
            //console.log(marketGroups);
            $.map(marketGroups,function(group){
                //console.log($(group.parentGroup).prop('href'));
                if (/*$(group.parentGroup).prop('href') === 'https://public-crest.eveonline.com/market/groups/2/'*/groupsList.indexOf($(group).prop('href')) >= 0) {
                    $("#marketGroups").append("<li data-cresthref='"+group.href+"' class='groupLink border'>"+group.name+"</li>");
                }
                }
            );
            $('.groupLink').click(function(event){event.stopPropagation();openSubGroupManage(event.target);/*console.log(event.target.firstChild.data);*/});
            $("#marketgroupmain").show();
        });


    }
   
    function openSubGroupManage(group)
    {
        var node;
        var itemcount=0;
        if ($(group).children('ul').length>0) {
            $(group).children('ul').toggle();
        } else {
            $(group).append('<ul class="subdisplay"></ul>');
            node=$(group).children('ul');
            $.map(marketGroups,function(subgroup){
            if (typeof subgroup.parentGroup != 'undefined' && subgroup.parentGroup.href === group.dataset.cresthref) {
                node.append("<li data-cresthref='"+subgroup.href+"' class='groupLink otherBorders'>"+subgroup.name+"</li>");
            }
            if (subgroup.href === group.dataset.cresthref) {
                $.getJSON(subgroup.types.href,function(data,status,xhr) {
                    $.map(data.items,function(item){
                        //console.log(arr.indexOf(item.type.href));
                        //console.log(item.type.href);
                        //console.log(item);
                        //console.log(subgroup);
                        console.log(item);
                        if(arr.indexOf(item.type.id_str) >= 0){
                            if (item.marketGroup.href== group.dataset.cresthref) {
                                node.append("<li data-cresthref='"+item.type.href+"' class='itemLink' typeID='"+ item.type.id_str +"'><img width=25 hieght=25 src='"+item.type.icon.href+"'  data-cresthref='"+item.type.href+"'>"+item.type.name+"&nbsp;&nbsp;<input type='checkbox' onchange='bpCheckedChanged(" + item.type.id_str + ")' checked>&nbsp;&nbsp;Own blueprint or capable of making</input>&nbsp;&nbsp;<input id='" + item.type.id_str + "-price' type='text' name='t' placeholder='Price' value='" + prices[item.type.id_str] + "'>&nbsp;&nbsp;</input><button type='button' onclick='setPrice(" + item.type.id_str + ")'>Set Price</button>&nbsp;&nbsp;</li>");
                                itemcount++;
                            }
                        }else{
                            if(item.marketGroup.href== group.dataset.cresthref){
                                node.append("<li class='itemLink' typeID='"+ item.type.id_str +"'><img width=25 hieght=25 src='"+item.type.icon.href+"'  data-cresthref='"+item.type.href+"'>"+item.type.name+ "&nbsp;&nbsp;<input type='checkbox' onchange='bpCheckedChanged(" + item.type.id_str + ")'name='cb'>&nbsp;&nbsp;Own blueprint or capable of making</input>&nbsp;&nbsp;<input id='" + item.type.id_str + "-price' type='text' name='t' placeholder='Price'>&nbsp;&nbsp;</input><button type='button' onclick='setPrice(" + item.type.id_str + ")'>Set Price</button>&nbsp;&nbsp;</li>");
                                itemcount++;
                            }
                        }
                    });
                    console.log(itemcount);
                    if (itemcount>0) {
                    console.log('items only');
                     //$('.itemLink').click(function(event){event.stopPropagation();openItem(event.target);});
                    }
                });
            }
            });
        }
    }
    $(document).ready(function() {

        //loadEndpoints();
        
    });


//}($, window, document)); // End crestexplorerjs
