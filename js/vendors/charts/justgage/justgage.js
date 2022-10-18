JustGage=function(d){var v=this;if(d===null||d===undefined){console.log("* justgage: Make sure to pass options to the constructor!");return false}var u;if(d.id!==null&&d.id!==undefined){u=document.getElementById(d.id);if(!u){console.log("* justgage: No element with id : %s found",d.id);return false}}else{if(d.parentNode!==null&&d.parentNode!==undefined){u=d.parentNode}else{console.log("* justgage: Make sure to pass the existing element id or parentNode to the constructor.");return false}}var e=u.dataset?u.dataset:{};var f=(d.defaults!==null&&d.defaults!==undefined)?d.defaults:false;if(f!==false){d=extend({},d,f);delete d.defaults}v.config={id:d.id,value:kvLookup("value",d,e,0,"float"),defaults:kvLookup("defaults",d,e,0,false),parentNode:kvLookup("parentNode",d,e,null),width:kvLookup("width",d,e,null),height:kvLookup("height",d,e,null),title:kvLookup("title",d,e,""),titleFontColor:kvLookup("titleFontColor",d,e,"#999999"),titleFontFamily:kvLookup("titleFontFamily",d,e,"sans-serif"),titlePosition:kvLookup("titlePosition",d,e,"above"),valueFontColor:kvLookup("valueFontColor",d,e,"#010101"),valueFontFamily:kvLookup("valueFontFamily",d,e,"Arial"),symbol:kvLookup("symbol",d,e,""),min:kvLookup("min",d,e,0,"float"),max:kvLookup("max",d,e,100,"float"),reverse:kvLookup("reverse",d,e,false),humanFriendlyDecimal:kvLookup("humanFriendlyDecimal",d,e,0),textRenderer:kvLookup("textRenderer",d,e,null),gaugeWidthScale:kvLookup("gaugeWidthScale",d,e,1),gaugeColor:kvLookup("gaugeColor",d,e,"#edebeb"),label:kvLookup("label",d,e,""),labelFontColor:kvLookup("labelFontColor",d,e,"#b3b3b3"),shadowOpacity:kvLookup("shadowOpacity",d,e,0.2),shadowSize:kvLookup("shadowSize",d,e,5),shadowVerticalOffset:kvLookup("shadowVerticalOffset",d,e,3),levelColors:kvLookup("levelColors",d,e,["#a9d70b","#f9c802","#ff0000"],"array",","),startAnimationTime:kvLookup("startAnimationTime",d,e,700),startAnimationType:kvLookup("startAnimationType",d,e,">"),refreshAnimationTime:kvLookup("refreshAnimationTime",d,e,700),refreshAnimationType:kvLookup("refreshAnimationType",d,e,">"),donutStartAngle:kvLookup("donutStartAngle",d,e,90),valueMinFontSize:kvLookup("valueMinFontSize",d,e,16),titleMinFontSize:kvLookup("titleMinFontSize",d,e,10),labelMinFontSize:kvLookup("labelMinFontSize",d,e,10),minLabelMinFontSize:kvLookup("minLabelMinFontSize",d,e,10),maxLabelMinFontSize:kvLookup("maxLabelMinFontSize",d,e,10),hideValue:kvLookup("hideValue",d,e,false),hideMinMax:kvLookup("hideMinMax",d,e,false),hideInnerShadow:kvLookup("hideInnerShadow",d,e,false),humanFriendly:kvLookup("humanFriendly",d,e,false),noGradient:kvLookup("noGradient",d,e,false),donut:kvLookup("donut",d,e,false),relativeGaugeSize:kvLookup("relativeGaugeSize",d,e,false),counter:kvLookup("counter",d,e,false),decimals:kvLookup("decimals",d,e,0),customSectors:kvLookup("customSectors",d,e,[]),formatNumber:kvLookup("formatNumber",d,e,false),pointer:kvLookup("pointer",d,e,false),pointerOptions:kvLookup("pointerOptions",d,e,[])};var c,b,F,E,a,h,i,y,z,A,B,C,D,j,k,l,r,s,t,n,o,p;if(v.config.value>v.config.max){v.config.value=v.config.max}if(v.config.value<v.config.min){v.config.value=v.config.min}v.originalValue=kvLookup("value",d,e,-1,"float");if(v.config.id!==null&&(document.getElementById(v.config.id))!==null){v.canvas=Raphael(v.config.id,"100%","100%")}else{if(v.config.parentNode!==null){v.canvas=Raphael(v.config.parentNode,"100%","100%")}}if(v.config.relativeGaugeSize===true){v.canvas.setViewBox(0,0,200,150,true)}if(v.config.relativeGaugeSize===true){c=200;b=150}else{if(v.config.width!==null&&v.config.height!==null){c=v.config.width;b=v.config.height}else{if(v.config.parentNode!==null){v.canvas.setViewBox(0,0,200,150,true);c=200;b=150}else{c=getStyle(document.getElementById(v.config.id),"width").slice(0,-2)*1;b=getStyle(document.getElementById(v.config.id),"height").slice(0,-2)*1}}}if(v.config.donut===true){if(c>b){E=b;F=E}else{if(c<b){F=c;E=F;if(E>b){a=E/b;E=E/a;F=E/a}}else{F=c;E=F}}h=(c-F)/2;i=(b-E)/2;y=((E/8)>10)?(E/10):10;z=h+F/2;A=i+E/11;B=((E/6.4)>16)?(E/5.4):18;C=h+F/2;if(v.config.label!==""){D=i+E/1.85}else{D=i+E/1.7}j=((E/16)>10)?(E/16):10;k=h+F/2;l=D+j;r=((E/16)>10)?(E/16):10;s=h+(F/10)+(F/6.666666666666667*v.config.gaugeWidthScale)/2;t=l;n=((E/16)>10)?(E/16):10;o=h+F-(F/10)-(F/6.666666666666667*v.config.gaugeWidthScale)/2;p=l}else{if(c>b){E=b;F=E*1.25;if(F>c){a=F/c;F=F/a;E=E/a}}else{if(c<b){F=c;E=F/1.25;if(E>b){a=E/b;E=E/a;F=E/a}}else{F=c;E=F*0.75}}h=(c-F)/2;i=(b-E)/2;if(v.config.titlePosition==="below"){i-=(E/6.4)}y=((E/8)>v.config.titleMinFontSize)?(E/10):v.config.titleMinFontSize;z=h+F/2;A=i+(v.config.titlePosition==="below"?(E*1.07):(E/6.4));B=((E/6.5)>v.config.valueMinFontSize)?(E/6.5):v.config.valueMinFontSize;C=h+F/2;D=i+E/1.275;j=((E/16)>v.config.labelMinFontSize)?(E/16):v.config.labelMinFontSize;k=h+F/2;l=D+B/2+5;r=((E/16)>v.config.minLabelMinFontSize)?(E/16):v.config.minLabelMinFontSize;s=h+(F/10)+(F/6.666666666666667*v.config.gaugeWidthScale)/2;t=l;n=((E/16)>v.config.maxLabelMinFontSize)?(E/16):v.config.maxLabelMinFontSize;o=h+F-(F/10)-(F/6.666666666666667*v.config.gaugeWidthScale)/2;p=l}v.params={canvasW:c,canvasH:b,widgetW:F,widgetH:E,dx:h,dy:i,titleFontSize:y,titleX:z,titleY:A,valueFontSize:B,valueX:C,valueY:D,labelFontSize:j,labelX:k,labelY:l,minFontSize:r,minX:s,minY:t,maxFontSize:n,maxX:o,maxY:p};c,b,F,E,a,h,i,y,z,A,B,C,D,j,k,l,r,s,t,n,o,p=null;v.canvas.customAttributes.pki=function(U,P,O,V,N,K,L,M,J,R){var G,T,S,H,I,X,Z,W,Y,Q;if(J){G=(1-2*(U-P)/(O-P))*Math.PI;T=V/2-V/7;S=T-V/6.666666666666667*M;H=V/2+K;I=N/1.95+L;X=V/2+K+T*Math.cos(G);Z=N-(N-I)-T*Math.sin(G);W=V/2+K+S*Math.cos(G);Y=N-(N-I)-S*Math.sin(G);Q="M"+(H-S)+","+I+" ";Q+="L"+(H-T)+","+I+" ";if(U>((O-P)/2)){Q+="A"+T+","+T+" 0 0 1 "+(H+T)+","+I+" "}Q+="A"+T+","+T+" 0 0 1 "+X+","+Z+" ";Q+="L"+W+","+Y+" ";if(U>((O-P)/2)){Q+="A"+S+","+S+" 0 0 0 "+(H+S)+","+I+" "}Q+="A"+S+","+S+" 0 0 0 "+(H-S)+","+I+" ";Q+="Z ";return{path:Q}}else{G=(1-(U-P)/(O-P))*Math.PI;T=V/2-V/10;S=T-V/6.666666666666667*M;H=V/2+K;I=N/1.25+L;X=V/2+K+T*Math.cos(G);Z=N-(N-I)-T*Math.sin(G);W=V/2+K+S*Math.cos(G);Y=N-(N-I)-S*Math.sin(G);Q="M"+(H-S)+","+I+" ";Q+="L"+(H-T)+","+I+" ";Q+="A"+T+","+T+" 0 0 1 "+X+","+Z+" ";Q+="L"+W+","+Y+" ";Q+="A"+S+","+S+" 0 0 0 "+(H-S)+","+I+" ";Q+="Z ";return{path:Q}}G,T,S,H,I,X,Z,W,Y,Q=null};v.canvas.customAttributes.ndl=function(W,S,R,X,Q,N,O,P,L){var K=X*3.5/100;var J=X/15;var M=X/100;if(v.config.pointerOptions.toplength!=null&&v.config.pointerOptions.toplength!=undefined){K=v.config.pointerOptions.toplength}if(v.config.pointerOptions.bottomlength!=null&&v.config.pointerOptions.bottomlength!=undefined){J=v.config.pointerOptions.bottomlength}if(v.config.pointerOptions.bottomwidth!=null&&v.config.pointerOptions.bottomwidth!=undefined){M=v.config.pointerOptions.bottomwidth}var G,V,U,H,I,ac,ai,ab,ah,aa,ag,ad,aj,Y,ae,Z,af,T;if(L){G=(1-2*(W-S)/(R-S))*Math.PI;V=X/2-X/7;U=V-X/6.666666666666667*P;H=X/2+N;I=Q/1.95+O;ac=X/2+N+V*Math.cos(G);ai=Q-(Q-I)-V*Math.sin(G);ab=X/2+N+U*Math.cos(G);ah=Q-(Q-I)-U*Math.sin(G);aa=ac+K*Math.cos(G);ag=ai-K*Math.sin(G);ad=ab-J*Math.cos(G);aj=ah+J*Math.sin(G);Y=ad+M*Math.sin(G);ae=aj+M*Math.cos(G);Z=ad-M*Math.sin(G);af=aj-M*Math.cos(G);T="M"+Y+","+ae+" ";T+="L"+Z+","+af+" ";T+="L"+aa+","+ag+" ";T+="Z ";return{path:T}}else{G=(1-(W-S)/(R-S))*Math.PI;V=X/2-X/10;U=V-X/6.666666666666667*P;H=X/2+N;I=Q/1.25+O;ac=X/2+N+V*Math.cos(G);ai=Q-(Q-I)-V*Math.sin(G);ab=X/2+N+U*Math.cos(G);ah=Q-(Q-I)-U*Math.sin(G);aa=ac+K*Math.cos(G);ag=ai-K*Math.sin(G);ad=ab-J*Math.cos(G);aj=ah+J*Math.sin(G);Y=ad+M*Math.sin(G);ae=aj+M*Math.cos(G);Z=ad-M*Math.sin(G);af=aj-M*Math.cos(G);T="M"+Y+","+ae+" ";T+="L"+Z+","+af+" ";T+="L"+aa+","+ag+" ";T+="Z ";return{path:T}}G,V,U,H,I,ac,ai,ab,ah,aa,ag,ad,aj,Y,ae,Z,af,T=null};v.gauge=v.canvas.path().attr({stroke:"none",fill:v.config.gaugeColor,pki:[v.config.max,v.config.min,v.config.max,v.params.widgetW,v.params.widgetH,v.params.dx,v.params.dy,v.config.gaugeWidthScale,v.config.donut,v.config.reverse]});v.level=v.canvas.path().attr({stroke:"none",fill:getColor(v.config.value,(v.config.value-v.config.min)/(v.config.max-v.config.min),v.config.levelColors,v.config.noGradient,v.config.customSectors),pki:[v.config.min,v.config.min,v.config.max,v.params.widgetW,v.params.widgetH,v.params.dx,v.params.dy,v.config.gaugeWidthScale,v.config.donut,v.config.reverse]});if(v.config.donut){v.level.transform("r"+v.config.donutStartAngle+", "+(v.params.widgetW/2+v.params.dx)+", "+(v.params.widgetH/1.95+v.params.dy))}if(v.config.pointer){v.needle=v.canvas.path().attr({stroke:(v.config.pointerOptions.stroke!==null&&v.config.pointerOptions.stroke!==undefined)?v.config.pointerOptions.stroke:"none","stroke-width":(v.config.pointerOptions.stroke_width!==null&&v.config.pointerOptions.stroke_width!==undefined)?v.config.pointerOptions.stroke_width:0,"stroke-linecap":(v.config.pointerOptions.stroke_linecap!==null&&v.config.pointerOptions.stroke_linecap!==undefined)?v.config.pointerOptions.stroke_linecap:"square",fill:(v.config.pointerOptions.color!==null&&v.config.pointerOptions.color!==undefined)?v.config.pointerOptions.color:"#000000",ndl:[v.config.min,v.config.min,v.config.max,v.params.widgetW,v.params.widgetH,v.params.dx,v.params.dy,v.config.gaugeWidthScale,v.config.donut]});if(v.config.donut){v.needle.transform("r"+v.config.donutStartAngle+", "+(v.params.widgetW/2+v.params.dx)+", "+(v.params.widgetH/1.95+v.params.dy))}}v.txtTitle=v.canvas.text(v.params.titleX,v.params.titleY,v.config.title);v.txtTitle.attr({"font-size":v.params.titleFontSize,"font-weight":"bold","font-family":v.config.titleFontFamily,fill:v.config.titleFontColor,"fill-opacity":"1"});setDy(v.txtTitle,v.params.titleFontSize,v.params.titleY);v.txtValue=v.canvas.text(v.params.valueX,v.params.valueY,0);v.txtValue.attr({"font-size":v.params.valueFontSize,"font-weight":"bold","font-family":v.config.valueFontFamily,fill:v.config.valueFontColor,"fill-opacity":"0"});setDy(v.txtValue,v.params.valueFontSize,v.params.valueY);v.txtLabel=v.canvas.text(v.params.labelX,v.params.labelY,v.config.label);v.txtLabel.attr({"font-size":v.params.labelFontSize,"font-weight":"normal","font-family":"Arial",fill:v.config.labelFontColor,"fill-opacity":"0"});setDy(v.txtLabel,v.params.labelFontSize,v.params.labelY);var q=v.config.min;if(v.config.reverse){q=v.config.max}v.txtMinimum=q;if(v.config.humanFriendly){v.txtMinimum=humanFriendlyNumber(q,v.config.humanFriendlyDecimal)}else{if(v.config.formatNumber){v.txtMinimum=formatNumber(q)}}v.txtMin=v.canvas.text(v.params.minX,v.params.minY,v.txtMinimum);v.txtMin.attr({"font-size":v.params.minFontSize,"font-weight":"normal","font-family":"Arial",fill:v.config.labelFontColor,"fill-opacity":(v.config.hideMinMax||v.config.donut)?"0":"1"});setDy(v.txtMin,v.params.minFontSize,v.params.minY);var m=v.config.max;if(v.config.reverse){m=v.config.min}v.txtMaximum=m;if(v.config.humanFriendly){v.txtMaximum=humanFriendlyNumber(m,v.config.humanFriendlyDecimal)}else{if(v.config.formatNumber){v.txtMaximum=formatNumber(m)}}v.txtMax=v.canvas.text(v.params.maxX,v.params.maxY,v.txtMaximum);v.txtMax.attr({"font-size":v.params.maxFontSize,"font-weight":"normal","font-family":"Arial",fill:v.config.labelFontColor,"fill-opacity":(v.config.hideMinMax||v.config.donut)?"0":"1"});setDy(v.txtMax,v.params.maxFontSize,v.params.maxY);var g=v.canvas.canvas.childNodes[1];var x="http://www.w3.org/2000/svg";if(ie!=="undefined"&&ie<9){}else{if(ie!=="undefined"){onCreateElementNsReady(function(){v.generateShadow(x,g)})}else{v.generateShadow(x,g)}}g,x=null;if(v.config.textRenderer){v.originalValue=v.config.textRenderer(v.originalValue)}else{if(v.config.humanFriendly){v.originalValue=humanFriendlyNumber(v.originalValue,v.config.humanFriendlyDecimal)+v.config.symbol}else{if(v.config.formatNumber){v.originalValue=formatNumber(v.originalValue)+v.config.symbol}else{v.originalValue=(v.originalValue*1).toFixed(v.config.decimals)+v.config.symbol}}}if(v.config.counter===true){eve.on("raphael.anim.frame."+(v.level.id),function(){var G=v.level.attr("pki")[0];if(v.config.reverse){G=(v.config.max*1)+(v.config.min*1)-(v.level.attr("pki")[0]*1)}if(v.config.textRenderer){v.txtValue.attr("text",v.config.textRenderer(Math.floor(G)))}else{if(v.config.humanFriendly){v.txtValue.attr("text",humanFriendlyNumber(Math.floor(G),v.config.humanFriendlyDecimal)+v.config.symbol)}else{if(v.config.formatNumber){v.txtValue.attr("text",formatNumber(Math.floor(G))+v.config.symbol)}else{v.txtValue.attr("text",(G*1).toFixed(v.config.decimals)+v.config.symbol)}}}setDy(v.txtValue,v.params.valueFontSize,v.params.valueY);G=null});eve.on("raphael.anim.finish."+(v.level.id),function(){v.txtValue.attr({text:v.originalValue});setDy(v.txtValue,v.params.valueFontSize,v.params.valueY)})}else{eve.on("raphael.anim.start."+(v.level.id),function(){v.txtValue.attr({text:v.originalValue});setDy(v.txtValue,v.params.valueFontSize,v.params.valueY)})}var w=v.config.value;if(v.config.reverse){w=(v.config.max*1)+(v.config.min*1)-(v.config.value*1)}v.level.animate({pki:[w,v.config.min,v.config.max,v.params.widgetW,v.params.widgetH,v.params.dx,v.params.dy,v.config.gaugeWidthScale,v.config.donut,v.config.reverse]},v.config.startAnimationTime,v.config.startAnimationType);if(v.config.pointer){v.needle.animate({ndl:[w,v.config.min,v.config.max,v.params.widgetW,v.params.widgetH,v.params.dx,v.params.dy,v.config.gaugeWidthScale,v.config.donut]},v.config.startAnimationTime,v.config.startAnimationType)}v.txtValue.animate({"fill-opacity":(v.config.hideValue)?"0":"1"},v.config.startAnimationTime,v.config.startAnimationType);v.txtLabel.animate({"fill-opacity":"1"},v.config.startAnimationTime,v.config.startAnimationType)};JustGage.prototype.refresh=function(f,c){var d=this;var b,a,c=c||null;if(c!==null){d.config.max=c;d.txtMaximum=d.config.max;if(d.config.humanFriendly){d.txtMaximum=humanFriendlyNumber(d.config.max,d.config.humanFriendlyDecimal)}else{if(d.config.formatNumber){d.txtMaximum=formatNumber(d.config.max)}}if(!d.config.reverse){d.txtMax.attr({text:d.txtMaximum});setDy(d.txtMax,d.params.maxFontSize,d.params.maxY)}else{d.txtMin.attr({text:d.txtMaximum});setDy(d.txtMin,d.params.minFontSize,d.params.minY)}}b=f;if((f*1)>(d.config.max*1)){f=(d.config.max*1)}if((f*1)<(d.config.min*1)){f=(d.config.min*1)}a=getColor(f,(f-d.config.min)/(d.config.max-d.config.min),d.config.levelColors,d.config.noGradient,d.config.customSectors);if(d.config.textRenderer){b=d.config.textRenderer(b)}else{if(d.config.humanFriendly){b=humanFriendlyNumber(b,d.config.humanFriendlyDecimal)+d.config.symbol}else{if(d.config.formatNumber){b=formatNumber((b*1).toFixed(d.config.decimals))+d.config.symbol}else{b=(b*1).toFixed(d.config.decimals)+d.config.symbol}}}d.originalValue=b;d.config.value=f*1;if(!d.config.counter){d.txtValue.attr({text:b});setDy(d.txtValue,d.params.valueFontSize,d.params.valueY)}var e=d.config.value;if(d.config.reverse){e=(d.config.max*1)+(d.config.min*1)-(d.config.value*1)}d.level.animate({pki:[e,d.config.min,d.config.max,d.params.widgetW,d.params.widgetH,d.params.dx,d.params.dy,d.config.gaugeWidthScale,d.config.donut,d.config.reverse],fill:a},d.config.refreshAnimationTime,d.config.refreshAnimationType);if(d.config.pointer){d.needle.animate({ndl:[e,d.config.min,d.config.max,d.params.widgetW,d.params.widgetH,d.params.dx,d.params.dy,d.config.gaugeWidthScale,d.config.donut]},d.config.refreshAnimationTime,d.config.refreshAnimationType)}d,b,a,c=null};JustGage.prototype.generateShadow=function(k,a){var i=this;var j="inner-shadow-"+i.config.id;var h,g,f,b,e,c,d;h=document.createElementNS(k,"filter");h.setAttribute("id",j);a.appendChild(h);g=document.createElementNS(k,"feOffset");g.setAttribute("dx",0);g.setAttribute("dy",i.config.shadowVerticalOffset);h.appendChild(g);f=document.createElementNS(k,"feGaussianBlur");f.setAttribute("result","offset-blur");f.setAttribute("stdDeviation",i.config.shadowSize);h.appendChild(f);b=document.createElementNS(k,"feComposite");b.setAttribute("operator","out");b.setAttribute("in","SourceGraphic");b.setAttribute("in2","offset-blur");b.setAttribute("result","inverse");h.appendChild(b);e=document.createElementNS(k,"feFlood");e.setAttribute("flood-color","black");e.setAttribute("flood-opacity",i.config.shadowOpacity);e.setAttribute("result","color");h.appendChild(e);c=document.createElementNS(k,"feComposite");c.setAttribute("operator","in");c.setAttribute("in","color");c.setAttribute("in2","inverse");c.setAttribute("result","shadow");h.appendChild(c);d=document.createElementNS(k,"feComposite");d.setAttribute("operator","over");d.setAttribute("in","shadow");d.setAttribute("in2","SourceGraphic");h.appendChild(d);if(!i.config.hideInnerShadow){i.canvas.canvas.childNodes[2].setAttribute("filter","url(#"+j+")");i.canvas.canvas.childNodes[3].setAttribute("filter","url(#"+j+")")}h,g,f,b,e,c,d=null};function kvLookup(e,f,g,c,b,d){var h=c;var a=false;if(!(e===null||e===undefined)){if(g!==null&&g!==undefined&&typeof g==="object"&&e in g){h=g[e];a=true}else{if(f!==null&&f!==undefined&&typeof f==="object"&&e in f){h=f[e];a=true}else{h=c}}if(a===true){if(b!==null&&b!==undefined){switch(b){case"int":h=parseInt(h,10);break;case"float":h=parseFloat(h);break;default:break}}}}return h}function getColor(w,o,b,n,e){var m,h,d,r,u,f,a,l,v,s,t,p,q,c;var n=n||e.length>0;if(e.length>0){for(var g=0;g<e.length;g++){if(w>e[g].lo&&w<=e[g].hi){return e[g].color}}}m=b.length;if(m===1){return b[0]}h=(n)?(1/m):(1/(m-1));d=[];for(g=0;g<b.length;g++){r=(n)?(h*(g+1)):(h*g);u=parseInt((cutHex(b[g])).substring(0,2),16);f=parseInt((cutHex(b[g])).substring(2,4),16);a=parseInt((cutHex(b[g])).substring(4,6),16);d[g]={pct:r,color:{r:u,g:f,b:a}}}if(o===0){return"rgb("+[d[0].color.r,d[0].color.g,d[0].color.b].join(",")+")"}for(var k=0;k<d.length;k++){if(o<=d[k].pct){if(n){return"rgb("+[d[k].color.r,d[k].color.g,d[k].color.b].join(",")+")"}else{l=d[k-1];v=d[k];s=v.pct-l.pct;t=(o-l.pct)/s;p=1-t;q=t;c={r:Math.floor(l.color.r*p+v.color.r*q),g:Math.floor(l.color.g*p+v.color.g*q),b:Math.floor(l.color.b*p+v.color.b*q)};return"rgb("+[c.r,c.g,c.b].join(",")+")"}}}}function setDy(a,b,c){if((!ie||ie>9)&&a.node.firstChild.attributes.dy){a.node.firstChild.attributes.dy.value=0}}function getRandomInt(b,a){return Math.floor(Math.random()*(a-b+1))+b}function cutHex(a){return(a.charAt(0)=="#")?a.substring(1,7):a}function humanFriendlyNumber(e,a){var f,b,c,g;f=Math.pow;b=f(10,a);c=7;while(c){g=f(10,c--*3);if(g<=e){e=Math.round(e*b/g)/b+"KMGTPE"[c]}}return e}function formatNumber(b){var a=b.toString().split(".");a[0]=a[0].replace(/\B(?=(\d{3})+(?!\d))/g,",");return a.join(".")}function getStyle(a,b){var c="";if(document.defaultView&&document.defaultView.getComputedStyle){c=document.defaultView.getComputedStyle(a,"").getPropertyValue(b)}else{if(a.currentStyle){b=b.replace(/\-(\w)/g,function(e,d){return d.toUpperCase()});c=a.currentStyle[b]}}return c}function onCreateElementNsReady(a){if(document.createElementNS!==undefined){a()}else{setTimeout(function(){onCreateElementNsReady(a)},100)}}var ie=(function(){var c,d=3,b=document.createElement("div"),a=b.getElementsByTagName("i");while(b.innerHTML="<!--[if gt IE "+(++d)+"]><i></i><![endif]-->",a[0]){}return d>4?d:c}());function extend(c){c=c||{};for(var a=1;a<arguments.length;a++){if(!arguments[a]){continue}for(var b in arguments[a]){if(arguments[a].hasOwnProperty(b)){c[b]=arguments[a][b]}}}return c};