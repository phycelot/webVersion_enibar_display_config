<style style="text/css">
.scroll-right {
 height: 50px;	
 overflow: hidden;
 position: relative;
 background: yellow;
 color: orange;
 border: 1px solid orange;
}
.scroll-right p {
 position: absolute;
 width: 100%;
 height: 100%;
 margin: 0;
 line-height: 50px;
 text-align: center;
 /* Starting position */
 -moz-transform:translateX(-100%);
 -webkit-transform:translateX(-100%);	
 transform:translateX(-100%);
 /* Apply animation to this element */	
 -moz-animation: scroll-right 15s linear infinite;
 -webkit-animation: scroll-right 15s linear infinite;
 animation: scroll-right 15s linear infinite;
}
/* Move it (define the animation) */
@-moz-keyframes scroll-right {
 0%   { -moz-transform: translateX(-100%); }
 100% { -moz-transform: translateX(100%); }
}
@-webkit-keyframes scroll-right {
 0%   { -webkit-transform: translateX(-100%); }
 100% { -webkit-transform: translateX(100%); }
}
@keyframes scroll-right {
 0%   { 
 -moz-transform: translateX(-100%); /* Browser bug fix */
 -webkit-transform: translateX(-100%); /* Browser bug fix */
 transform: translateX(-100%); 		
 }
 100% { 
 -moz-transform: translateX(100%); /* Browser bug fix */
 -webkit-transform: translateX(100%); /* Browser bug fix */
 transform: translateX(100%); 
 }
}
</style>

<div class="scroll-right">
<p>Scroll right... </p>
</div>
