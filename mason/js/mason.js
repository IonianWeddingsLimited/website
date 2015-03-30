(function($){
$.fn.mason=function(options,complete){
	var defaults={
		itemSelector:null,
		ratio:0,
		sizes:[],
		columns:[[0,480,1],[480,780,2],[780,1080,3],[1080,1320,4],[1320,1680,5]],
		promoted:[],
		filler:{
			itemSelector:options.itemSelector,
			filler_class:"mason_filler"
		}
		,layout:"none",gutter:0};

		if(complete){
			var callback={complete:complete}
		}
		var elements={
			block:{
				height:0,
				width:0
			},matrix:[]
		};
		return this.each(function(){

			var settings,callbacks,$self;
			settings=$.extend(defaults,options);
			callbacks=$.extend(callback,complete);
			$self=$(this);
			function setup(){
				if($self.children(".mason_clear").length<1){
					$self.append("<div class='mason_clear' style='clear:both; position:relative;'></div>")}elements.block.height=parseFloat(($self.width()/columnSize()/settings.ratio).toFixed(0));
					elements.block.width=parseFloat($self.width()/columnSize());
sizeElements()}function sizeElements(){

var col=columnSize();
if(col==1){
$sel=$self.children(settings.itemSelector);
$sel.height(elements.block.height);
$sel.width(elements.block.width);
$sel.css({
margin:"0px"})}else{
for(
var i=0;
i<settings.promoted.length;
i++){
settings.sizes.push([settings.promoted[i][0],settings.promoted[i][1]])}$self.children(settings.itemSelector).each(function(){
$sel=$(this);
ran=Math.floor(Math.random()*(settings.sizes.length-settings.promoted.length));
ranSize=settings.sizes[ran];
for(
var i=0;
i<settings.promoted.length;
i++){
if($sel.hasClass(settings.promoted[i][2])){
ranSize=[settings.promoted[i][0],settings.promoted[i][1]];
ran=settings.sizes.length-settings.promoted.length+i}}$sel.data("size",ran);

var h=parseFloat((elements.block.height*ranSize[1]).toFixed(2));
h=h-settings.gutter*2;

var w=parseFloat(elements.block.width*ranSize[0]);
w=w-settings.gutter*2;
$sel.height(h+"px");
$sel.width(w+"px");
$sel.css({
margin:settings.gutter})});

var el_h=$self.height();

var block_h=el_h/elements.block.height;
elements.matrix=[];
for(
var i=0;
i<block_h;
i++){
elements.matrix[i]=[];
for(
var c=0;
c<col;
c++){
elements.matrix[i][c]=false}}$self.children(settings.itemSelector).each(function(){
$sel=$(this);

var l=Math.round($sel.position().left/elements.block.width);

var t=Math.round($sel.position().top/elements.block.height);

var s=parseFloat($sel.data("size"));

var h=settings.sizes[s][1];

var w=settings.sizes[s][0];

var a=h*w;
for(
var i=0;
i<a;
i++){
for(
var bh=0;
bh<h;
bh++){
elements.matrix[t+bh][l]=true;
for(
var bw=0;
bw<w;
bw++){
elements.matrix[t+bh][l+bw]=true}}}});
for(
var i=0;
i<elements.matrix.length;
i++){
for(
var c=0;
c<elements.matrix[i].length;
c++){
if(elements.matrix[i][c]==false){

var h=parseFloat(elements.block.height),w=parseFloat(elements.block.width);

var x=parseFloat((i*h).toFixed(2))+settings.gutter,y=parseFloat(c*w)+settings.gutter,ran,filler;
h=h-settings.gutter*2;
w=w-settings.gutter*2;
ran=Math.floor(Math.random()*$(settings.filler.itemSelector).length);
$(settings.filler.itemSelector).eq(ran).removeClass('filler');
filler=$(settings.filler.itemSelector).eq(ran).clone();
filler.addClass(settings.filler.filler_class);
filler.css({
position:"absolute",top:x+"px",left:y+"px",height:h+"px",width:w+"px",margin:"0px"});
filler.appendTo($self)}}}if(callbacks.complete!=null){
callbacks.complete()}}}function columnSize(){

var w=Math.floor($self.width()),cols=0,colsCount=settings.columns.length-1;
if(w>=settings.columns[colsCount][1]){
cols=settings.columns[colsCount][2]}else{
for(
var i=0;
i<=colsCount;
i++){
if(w>settings.columns[i][0]&&w<settings.columns[i][1]){
cols=settings.columns[i][2]}}}return cols}
var waitForFinalEvent=function(){

var timers={
};
return function(callback,ms,uniqueId){
if(!uniqueId){
uniqueId=random()}if(timers[uniqueId]){
clearTimeout(timers[uniqueId])}timers[uniqueId]=setTimeout(callback,ms)}}();

var random=function(){

var text="";

var possible="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
for(
var i=0;
i<5;
i++)text+=possible.charAt(Math.floor(Math.random()*possible.length));
return text};
if(settings.layout=="fluid"){
$(window).resize(function(){
$("."+settings.filler.filler_class).remove();
elements.matrix=[];
waitForFinalEvent(function(){
$("."+settings.filler.filler_class).remove();
setup()},150)})}setup()})}})(jQuery);
