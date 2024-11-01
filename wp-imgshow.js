

// Set the duration of crossfade (in seconds)
var CrossFadeDuration = 2;




// =====================================
// Do not edit anything below this line!
// =====================================

var tss;
var iss;
var jss = 1;
var pss = Picture.length-1;

var preLoad = new Array();
for (iss = 1; iss < pss+1; iss++)
{
	preLoad[iss] = new Image();
	preLoad[iss].src = Picture[iss];
}

function runSlideShow_old()
{
	if (document.all)
	{
		document.images.PictureBox.style.filter="blendTrans(duration=2)";
		document.images.PictureBox.style.filter="blendTrans(duration=CrossFadeDuration)";
		document.images.PictureBox.filters.blendTrans.Apply();
	}
	
	document.images.PictureBox.src = preLoad[jss].src;
	
	if (document.getElementById) 
		document.getElementById("CaptionBox").innerHTML= Caption[jss];
	
	if (document.all) 
		document.images.PictureBox.filters.blendTrans.Play();
		
	jss = jss + 1;
	
	if (jss > (pss)) 
			jss=1;
	tss = setTimeout('runSlideShow()', SlideShowSpeed);
}


function nextImage()
{
	document.images.PictureBox.src = preLoad[jss].src;
		
	if (document.getElementById) 
			document.getElementById("CaptionBox").innerHTML= Caption[jss];
		
	jss = jss + 1;
		
	if (jss > (pss)) 
		jss=1;
		
	opacity("PictureBox", 0, 100, CrossFadeDuration * 1000);
}

function runSlideShow()
{	
	
	opacity("PictureBox", 100, 0, CrossFadeDuration * 1000);
	
	
	
}


function opacity(id, opacStart, opacEnd, millisec) {
    //speed for each frame
    var speed = Math.round(millisec / 100);
    var timer = 0;

    //determine the direction for the blending, if start and end are the same nothing happens
    // desvanece
    if(opacStart > opacEnd) {
        
        for(i = opacStart; i >= opacEnd; i--) 
        {
            setTimeout("changeOpac(" + i + ",'" + id + "')",(timer * speed));
            timer++;
        }
        setTimeout("nextImage()",(timer * speed));
        
    } else 
       if(opacStart < opacEnd) {
        for(i = opacStart; i <= opacEnd; i++)
            {
            setTimeout("changeOpac(" + i + ",'" + id + "')",(timer * speed));
            timer++;
        }
        tss = setTimeout('runSlideShow()', SlideShowSpeed);
        
    }
    
    
}

//change the opacity for different browsers
function changeOpac(opacity, id) {
    var object = document.getElementById(id).style;
    object.opacity = (opacity / 100);
    object.MozOpacity = (opacity / 100);
    object.KhtmlOpacity = (opacity / 100);
    object.filter = "alpha(opacity=" + opacity + ")";
} 