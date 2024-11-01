function serialize(r){var e,n,t,a="",i="",o=0,s=function(r){var e=0,n=0,t=r.length,a="";for(n=0;t>n;n++)a=r.charCodeAt(n),e+=128>a?1:2048>a?2:3;return e};switch(_getType=function(r){var e,n,t,a,i=typeof r;if("object"===i&&!r)return"null";if("object"===i){if(!r.constructor)return"object";t=r.constructor.toString(),e=t.match(/(\w+)\(/),e&&(t=e[1].toLowerCase()),a=["boolean","number","string","array"];for(n in a)if(t===a[n]){i=a[n];break}}return i},type=_getType(r),type){case"function":e="";break;case"boolean":e="b:"+(r?"1":"0");break;case"number":e=(Math.round(r)===r?"i":"d")+":"+r;break;case"string":e="s:"+s(r)+':"'+r+'"';break;case"array":case"object":e="a";for(n in r)if(r.hasOwnProperty(n)){if(a=_getType(r[n]),"function"===a)continue;t=n.match(/^[0-9]+$/)?parseInt(n,10):n,i+=this.serialize(t)+this.serialize(r[n]),o++}e+=":"+o+":{"+i+"}";break;case"undefined":default:e="N"}return"object"!==type&&"array"!==type&&("string"===type&&-1!==e.indexOf("}")||(e+=";")),e}function unserialize(r){var e=this,n=function(r){var e=r.charCodeAt(0);return 128>e?0:2048>e?1:2};return error=function(r,n,t,a){throw new e.window[r](n,t,a)},read_until=function(r,e,n){for(var t=2,a=[],i=r.slice(e,e+1);i!==n;)t+e>r.length&&error("Error","Invalid"),a.push(i),i=r.slice(e+(t-1),e+t),t+=1;return[a.length,a.join("")]},read_chrs=function(r,e,t){var a,i,o;for(o=[],a=0;t>a;a++)i=r.slice(e+(a-1),e+a),o.push(i),t-=n(i);return[o.length,o.join("")]},_unserialize=function(r,e){var n,t,a,i,o,s,u,c,l,f,h,b,d,p,y,_,g,k,w=0,v=function(r){return r};switch(e||(e=0),n=r.slice(e,e+1).toLowerCase(),t=e+2,n){case"i":v=function(r){return parseInt(r,10)},l=read_until(r,t,";"),w=l[0],c=l[1],t+=w+1;break;case"b":v=function(r){return 0!==parseInt(r,10)},l=read_until(r,t,";"),w=l[0],c=l[1],t+=w+1;break;case"d":v=function(r){return parseFloat(r)},l=read_until(r,t,";"),w=l[0],c=l[1],t+=w+1;break;case"n":c=null;break;case"s":f=read_until(r,t,":"),w=f[0],h=f[1],t+=w+2,l=read_chrs(r,t+1,parseInt(h,10)),w=l[0],c=l[1],t+=w+2,w!==parseInt(h,10)&&w!==c.length&&error("SyntaxError","String length mismatch");break;case"a":for(c={},a=read_until(r,t,":"),w=a[0],i=a[1],t+=w+2,s=parseInt(i,10),o=!0,b=0;s>b;b++)p=_unserialize(r,t),y=p[1],d=p[2],t+=y,_=_unserialize(r,t),g=_[1],k=_[2],t+=g,d!==b&&(o=!1),c[d]=k;if(o){for(u=new Array(s),b=0;s>b;b++)u[b]=c[b];c=u}t+=1;break;default:error("SyntaxError","Unknown / Unhandled data type(s): "+n)}return[n,t-e,v(c)]},_unserialize(r+"",0)[2]}