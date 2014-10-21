package {
    import mx.core.*;

    public class Main_img_bg extends BitmapAsset {

    }
}//package 
﻿package {
    import flash.utils.*;
    import flash.events.*;
    import flash.ui.*;
    import flash.display.*;
    import com.onez.common.*;
    import lt.uza.ui.*;
    import flash.geom.*;
    import flash.text.*;
    import com.onez.skin.*;
    import flash.filters.*;
    import flash.media.*;
    import flash.net.*;

    public class Main extends Sprite {

        private static const img_bg:Class = Main_img_bg;
        private static const img001:Class = Main_img001;
        private static const img002:Class = Main_img002;
        private static const img003:Class = Main_img003;
        private static const img_normal:Class = Main_img_normal;

        private var iconBox:Sprite;
        private var icons:Object;
        private var timer:Timer;
        private var sound:Sound;
        private var soundC:SoundChannel;
        private var length:int = 0;
        private var time:Label;
        private var _playing:Boolean;
        private var sec:int = 0;

        public function Main():void{
            this.icons = {};
            this.timer = new Timer(400);
            super();
            if (stage){
                this.init();
            } else {
                addEventListener(Event.ADDED_TO_STAGE, this.init);
            };
        }
        private function init(e:Event=null):void{
            var item:ContextMenuItem;
            removeEventListener(Event.ADDED_TO_STAGE, this.init);
            stage.scaleMode = StageScaleMode.NO_SCALE;
            stage.align = StageAlign.TOP_LEFT;
            Onez.init(stage, this);
            Onez.info.siteurl = this.stage.loaderInfo.loaderURL.split("/source/plugin/")[0];
            var d:DisplayObject = new img_bg();
            this.setColor(d);
            var bitmap:BitmapData = new BitmapData(d.width, d.height, true, 0);
            bitmap.draw(d);
            var box:Scale9BitmapSprite = new Scale9BitmapSprite(bitmap, new Rectangle(15, 9, 23, 20));
            box.width = 80;
            addChild(box);
            this.iconBox = new Sprite();
            this.iconBox.x = 15;
            this.iconBox.y = 9;
            box.addChild(this.iconBox);
            this.setColor(this.iconBox);
            var tf:TextFormat = new TextFormat();
            tf.font = "Arial";
            this.time = new Label("", 4612878, "right", tf);
            this.setColor(this.time.t);
            this.time.x = -30;
            this.time.y = 8;
            this.time.text = "";
            this.time.alpha = 0.8;
            this.time.filters = [new GlowFilter(279620, 0.5, 2, 2, 1)];
            this.time.t.selectable = false;
            box.addChild(this.time);
            this.iconBox.addChild((this.icons.tnormal = new img_normal()));
            this.iconBox.addChild((this.icons.t001 = new img001()));
            this.iconBox.addChild((this.icons.t002 = new img002()));
            this.iconBox.addChild((this.icons.t003 = new img003()));
            this.showIcon("normal");
            this.timer.addEventListener(TimerEvent.TIMER, this.onTimer);
            var mp3url:String = "";
            if (typeof(this.stage.loaderInfo.parameters.son) != "undefined"){
                mp3url = this.stage.loaderInfo.parameters.son.toString();
            };
            if (mp3url == ""){
                return;
            };
            box.buttonMode = true;
            box.addEventListener(MouseEvent.CLICK, this.onClick);
            if (mp3url.substr(0, 7) == "http://"){
                this.playMP3(mp3url);
            } else {
                if (isNaN(Number(mp3url))){
                    OnezLoader.load((Onez.info.siteurl + "/plugin.php?id=tsound&action=mp3"), this.playMP3, "text", {key:mp3url});
                } else {
                    OnezLoader.load("http://2cscs.onez.cn/onez.php?action=file", this.playMP3, "text", {
                        fileid:mp3url,
                        siteurl:Onez.info.siteurl
                    });
                };
            };
            var myContextMenu:ContextMenu = new ContextMenu();
            myContextMenu.hideBuiltInItems();
            var i:int = 10;
            while (i <= 100) {
                item = new ContextMenuItem(("音量" + i), false);
                item.addEventListener(ContextMenuEvent.MENU_ITEM_SELECT, Delegate.create(this.setVol, i));
                myContextMenu.customItems.push(item);
                i = (i + 10);
            };
            this.contextMenu = myContextMenu;
        }
        public function setVol(e:ContextMenuEvent, vol:Number):void{
            var soundTF:SoundTransform;
            if (this.soundC){
                soundTF = new SoundTransform();
                soundTF.volume = (vol / 100);
                this.soundC.soundTransform = soundTF;
            };
        }
        private function setColor(d:DisplayObject):void{
            if (Onez.option("color", "green") == "green"){
                return;
            };
            var matrix:Array = [];
            var c:uint;
            switch (Onez.option("color")){
                case "red":
                    c = 16719399;
                    break;
                case "pink":
                    c = 16735330;
                    break;
                case "blue":
                    c = 2329599;
                    break;
            };
            var r:int = (c >> 16);
            var g:int = ((c - (r << 16)) >> 8);
            var b:int = ((c - (r << 16)) - (g << 8));
            matrix = matrix.concat([(r / 0xFF), (r / 0xFF), (r / 0xFF), 0, 0]);
            matrix = matrix.concat([(g / 0xFF), (g / 0xFF), (g / 0xFF), 0, 0]);
            matrix = matrix.concat([(b / 0xFF), (b / 0xFF), (b / 0xFF), 0, 0]);
            matrix = matrix.concat([0, 0, 0, 1, 0]);
            d.filters = [new ColorMatrixFilter(matrix)];
        }
        private function playMP3(mp3url:String):void{
            if (mp3url == null){
                return;
            };
            this.sound = new Sound(new URLRequest(mp3url));
            this.sound.addEventListener(IOErrorEvent.IO_ERROR, this.onComplete);
            this.addEventListener(Event.ENTER_FRAME, this.onEnterFrame);
        }
        private function onEnterFrame(e:Event):void{
            if (this.length == this.sound.length){
                return;
            };
            this.length = this.sound.length;
            var t:int = Math.floor((this.length / 1000));
            var s:String = ((t % 60) + "’’");
            t = Math.floor((t / 60));
            if (t > 0){
                s = ((t + "’") + s);
            };
            this.time.text = s;
        }
        public function get playing():Boolean{
            return (this._playing);
        }
        public function set playing(value:Boolean):void{
            this._playing = value;
            if (this.playing){
                this.sec = 0;
                this.showIcon("000");
                this.timer.start();
                if (this.sound){
                    this.soundC = this.sound.play(0);
                    this.soundC.addEventListener(Event.SOUND_COMPLETE, this.onComplete);
                };
            } else {
                if (this.soundC){
                    this.soundC.removeEventListener(Event.SOUND_COMPLETE, this.onComplete);
                    this.soundC.stop();
                };
                this.timer.stop();
                this.showIcon("normal");
            };
        }
        private function onComplete(e:Event):void{
            this.playing = false;
        }
        private function onClick(e:MouseEvent):void{
            this.playing = !(this.playing);
        }
        private function onTimer(e:TimerEvent):void{
            this.sec++;
            switch (this.sec){
                case 1:
                    this.showIcon("000");
                    break;
                case 2:
                    this.showIcon("001");
                    break;
                case 3:
                    this.showIcon("002");
                    break;
                case 4:
                    this.showIcon("003");
                    this.sec = 0;
                    break;
            };
        }
        private function showIcon(token:String):void{
            var k:String;
            for (k in this.icons) {
                this.icons[k].visible = (k == ("t" + token));
            };
        }

    }
}//package 
﻿package mx.core {

    public namespace mx_internal = "http://www.adobe.com/2006/flex/mx/internal";
}//package mx.core 
﻿package mx.core {
    import mx.utils.*;
    import flash.display.*;

    public class FlexBitmap extends Bitmap {

        mx_internal static const VERSION:String = "4.1.0.21490";

        public function FlexBitmap(bitmapData:BitmapData=null, pixelSnapping:String="auto", smoothing:Boolean=false){
            var bitmapData = bitmapData;
            var pixelSnapping:String = pixelSnapping;
            var smoothing:Boolean = smoothing;
            super(bitmapData, pixelSnapping, smoothing);
            try {
                name = NameUtil.createUniqueName(this);
            } catch(e:Error) {
            };
        }
        override public function toString():String{
            return (NameUtil.displayObjectToString(this));
        }

    }
}//package mx.core 
﻿package mx.core {
    import flash.geom.*;

    public interface IAssetLayoutFeatures {

        function set layoutX(_arg1:Number):void;
        function get layoutX():Number;
        function set layoutY(_arg1:Number):void;
        function get layoutY():Number;
        function set layoutZ(_arg1:Number):void;
        function get layoutZ():Number;
        function get layoutWidth():Number;
        function set layoutWidth(_arg1:Number):void;
        function set transformX(_arg1:Number):void;
        function get transformX():Number;
        function set transformY(_arg1:Number):void;
        function get transformY():Number;
        function set transformZ(_arg1:Number):void;
        function get transformZ():Number;
        function set layoutRotationX(_arg1:Number):void;
        function get layoutRotationX():Number;
        function set layoutRotationY(_arg1:Number):void;
        function get layoutRotationY():Number;
        function set layoutRotationZ(_arg1:Number):void;
        function get layoutRotationZ():Number;
        function set layoutScaleX(_arg1:Number):void;
        function get layoutScaleX():Number;
        function set layoutScaleY(_arg1:Number):void;
        function get layoutScaleY():Number;
        function set layoutScaleZ(_arg1:Number):void;
        function get layoutScaleZ():Number;
        function set layoutMatrix(_arg1:Matrix):void;
        function get layoutMatrix():Matrix;
        function set layoutMatrix3D(_arg1:Matrix3D):void;
        function get layoutMatrix3D():Matrix3D;
        function get is3D():Boolean;
        function get layoutIs3D():Boolean;
        function get mirror():Boolean;
        function set mirror(_arg1:Boolean):void;
        function get stretchX():Number;
        function set stretchX(_arg1:Number):void;
        function get stretchY():Number;
        function set stretchY(_arg1:Number):void;
        function get computedMatrix():Matrix;
        function get computedMatrix3D():Matrix3D;

    }
}//package mx.core 
﻿package mx.core {

    public interface ILayoutDirectionElement {

        function get layoutDirection():String;
        function set layoutDirection(_arg1:String):void;
        function invalidateLayoutDirection():void;

    }
}//package mx.core 
﻿package mx.core {

    public interface IFlexAsset {

    }
}//package mx.core 
﻿package mx.core {
    import flash.system.*;
    import flash.events.*;
    import flash.display.*;
    import flash.geom.*;

    public class BitmapAsset extends FlexBitmap implements IFlexAsset, IFlexDisplayObject, ILayoutDirectionElement {

        mx_internal static const VERSION:String = "4.1.0.21490";

        private static var FlexVersionClass:Class;
        private static var MatrixUtilClass:Class;

        private var layoutFeaturesClass:Class;
        private var layoutFeatures:IAssetLayoutFeatures;
        private var _height:Number;
        private var _layoutDirection:String = "ltr";

        public function BitmapAsset(bitmapData:BitmapData=null, pixelSnapping:String="auto", smoothing:Boolean=false){
            var appDomain:ApplicationDomain;
            super(bitmapData, pixelSnapping, smoothing);
            if (FlexVersionClass == null){
                appDomain = ApplicationDomain.currentDomain;
                if (appDomain.hasDefinition("mx.core::FlexVersion")){
                    FlexVersionClass = Class(appDomain.getDefinition("mx.core::FlexVersion"));
                };
            };
            if (((FlexVersionClass) && ((FlexVersionClass["compatibilityVersion"] >= FlexVersionClass["VERSION_4_0"])))){
                this.addEventListener(Event.ADDED, this.addedHandler);
            };
        }
        override public function get x():Number{
            return (((this.layoutFeatures)==null) ? super.x : this.layoutFeatures.layoutX);
        }
        override public function set x(value:Number):void{
            if (this.x == value){
                return;
            };
            if (this.layoutFeatures == null){
                super.x = value;
            } else {
                this.layoutFeatures.layoutX = value;
                this.validateTransformMatrix();
            };
        }
        override public function get y():Number{
            return (((this.layoutFeatures)==null) ? super.y : this.layoutFeatures.layoutY);
        }
        override public function set y(value:Number):void{
            if (this.y == value){
                return;
            };
            if (this.layoutFeatures == null){
                super.y = value;
            } else {
                this.layoutFeatures.layoutY = value;
                this.validateTransformMatrix();
            };
        }
        override public function get z():Number{
            return (((this.layoutFeatures)==null) ? super.z : this.layoutFeatures.layoutZ);
        }
        override public function set z(value:Number):void{
            if (this.z == value){
                return;
            };
            if (this.layoutFeatures == null){
                super.z = value;
            } else {
                this.layoutFeatures.layoutZ = value;
                this.validateTransformMatrix();
            };
        }
        override public function get width():Number{
            var p:Point;
            if (this.layoutFeatures == null){
                return (super.width);
            };
            if (MatrixUtilClass != null){
                p = MatrixUtilClass["transformSize"](this.layoutFeatures.layoutWidth, this._height, transform.matrix);
            };
            return (((p) ? p.x : super.width));
        }
        override public function set width(value:Number):void{
            if (this.width == value){
                return;
            };
            if (this.layoutFeatures == null){
                super.width = value;
            } else {
                this.layoutFeatures.layoutWidth = value;
                this.layoutFeatures.layoutScaleX = ((!((this.measuredWidth == 0))) ? (value / this.measuredWidth) : 0);
                this.validateTransformMatrix();
            };
        }
        override public function get height():Number{
            var p:Point;
            if (this.layoutFeatures == null){
                return (super.height);
            };
            if (MatrixUtilClass != null){
                p = MatrixUtilClass["transformSize"](this.layoutFeatures.layoutWidth, this._height, transform.matrix);
            };
            return (((p) ? p.y : super.height));
        }
        override public function set height(value:Number):void{
            if (this.height == value){
                return;
            };
            if (this.layoutFeatures == null){
                super.height = value;
            } else {
                this._height = value;
                this.layoutFeatures.layoutScaleY = ((!((this.measuredHeight == 0))) ? (value / this.measuredHeight) : 0);
                this.validateTransformMatrix();
            };
        }
        override public function get rotationX():Number{
            return (((this.layoutFeatures)==null) ? super.rotationX : this.layoutFeatures.layoutRotationX);
        }
        override public function set rotationX(value:Number):void{
            if (this.rotationX == value){
                return;
            };
            if (this.layoutFeatures == null){
                super.rotationX = value;
            } else {
                this.layoutFeatures.layoutRotationX = value;
                this.validateTransformMatrix();
            };
        }
        override public function get rotationY():Number{
            return (((this.layoutFeatures)==null) ? super.rotationY : this.layoutFeatures.layoutRotationY);
        }
        override public function set rotationY(value:Number):void{
            if (this.rotationY == value){
                return;
            };
            if (this.layoutFeatures == null){
                super.rotationY = value;
            } else {
                this.layoutFeatures.layoutRotationY = value;
                this.validateTransformMatrix();
            };
        }
        override public function get rotationZ():Number{
            return (((this.layoutFeatures)==null) ? super.rotationZ : this.layoutFeatures.layoutRotationZ);
        }
        override public function set rotationZ(value:Number):void{
            if (this.rotationZ == value){
                return;
            };
            if (this.layoutFeatures == null){
                super.rotationZ = value;
            } else {
                this.layoutFeatures.layoutRotationZ = value;
                this.validateTransformMatrix();
            };
        }
        override public function get rotation():Number{
            return (((this.layoutFeatures)==null) ? super.rotation : this.layoutFeatures.layoutRotationZ);
        }
        override public function set rotation(value:Number):void{
            if (this.rotation == value){
                return;
            };
            if (this.layoutFeatures == null){
                super.rotation = value;
            } else {
                this.layoutFeatures.layoutRotationZ = value;
                this.validateTransformMatrix();
            };
        }
        override public function get scaleX():Number{
            return (((this.layoutFeatures)==null) ? super.scaleX : this.layoutFeatures.layoutScaleX);
        }
        override public function set scaleX(value:Number):void{
            if (this.scaleX == value){
                return;
            };
            if (this.layoutFeatures == null){
                super.scaleX = value;
            } else {
                this.layoutFeatures.layoutScaleX = value;
                this.layoutFeatures.layoutWidth = (Math.abs(value) * this.measuredWidth);
                this.validateTransformMatrix();
            };
        }
        override public function get scaleY():Number{
            return (((this.layoutFeatures)==null) ? super.scaleY : this.layoutFeatures.layoutScaleY);
        }
        override public function set scaleY(value:Number):void{
            if (this.scaleY == value){
                return;
            };
            if (this.layoutFeatures == null){
                super.scaleY = value;
            } else {
                this.layoutFeatures.layoutScaleY = value;
                this._height = (Math.abs(value) * this.measuredHeight);
                this.validateTransformMatrix();
            };
        }
        override public function get scaleZ():Number{
            return (((this.layoutFeatures)==null) ? super.scaleZ : this.layoutFeatures.layoutScaleZ);
        }
        override public function set scaleZ(value:Number):void{
            if (this.scaleZ == value){
                return;
            };
            if (this.layoutFeatures == null){
                super.scaleZ = value;
            } else {
                this.layoutFeatures.layoutScaleZ = value;
                this.validateTransformMatrix();
            };
        }
        public function get layoutDirection():String{
            return (this._layoutDirection);
        }
        public function set layoutDirection(value:String):void{
            if (value == this._layoutDirection){
                return;
            };
            this._layoutDirection = value;
            this.invalidateLayoutDirection();
        }
        public function get measuredHeight():Number{
            if (bitmapData){
                return (bitmapData.height);
            };
            return (0);
        }
        public function get measuredWidth():Number{
            if (bitmapData){
                return (bitmapData.width);
            };
            return (0);
        }
        public function invalidateLayoutDirection():void{
            var mirror:Boolean;
            var p:DisplayObjectContainer = parent;
            while (p) {
                if ((p is ILayoutDirectionElement)){
                    mirror = ((!((this._layoutDirection == null))) && (!((this._layoutDirection == ILayoutDirectionElement(p).layoutDirection))));
                    if (((mirror) && ((this.layoutFeatures == null)))){
                        this.initAdvancedLayoutFeatures();
                        if (this.layoutFeatures != null){
                            this.layoutFeatures.mirror = mirror;
                            this.validateTransformMatrix();
                        };
                    } else {
                        if (((!(mirror)) && (this.layoutFeatures))){
                            this.layoutFeatures.mirror = mirror;
                            this.validateTransformMatrix();
                            this.layoutFeatures = null;
                        };
                    };
                    break;
                };
                p = p.parent;
            };
        }
        public function move(x:Number, y:Number):void{
            this.x = x;
            this.y = y;
        }
        public function setActualSize(newWidth:Number, newHeight:Number):void{
            this.width = newWidth;
            this.height = newHeight;
        }
        private function addedHandler(event:Event):void{
            this.invalidateLayoutDirection();
        }
        private function initAdvancedLayoutFeatures():void{
            var appDomain:ApplicationDomain;
            var features:IAssetLayoutFeatures;
            if (this.layoutFeaturesClass == null){
                appDomain = ApplicationDomain.currentDomain;
                if (appDomain.hasDefinition("mx.core::AdvancedLayoutFeatures")){
                    this.layoutFeaturesClass = Class(appDomain.getDefinition("mx.core::AdvancedLayoutFeatures"));
                };
                if (MatrixUtilClass == null){
                    if (appDomain.hasDefinition("mx.utils::MatrixUtil")){
                        MatrixUtilClass = Class(appDomain.getDefinition("mx.utils::MatrixUtil"));
                    };
                };
            };
            if (this.layoutFeaturesClass != null){
                features = new this.layoutFeaturesClass();
                features.layoutScaleX = this.scaleX;
                features.layoutScaleY = this.scaleY;
                features.layoutScaleZ = this.scaleZ;
                features.layoutRotationX = this.rotationX;
                features.layoutRotationY = this.rotationY;
                features.layoutRotationZ = this.rotation;
                features.layoutX = this.x;
                features.layoutY = this.y;
                features.layoutZ = this.z;
                features.layoutWidth = this.width;
                this._height = this.height;
                this.layoutFeatures = features;
            };
        }
        private function validateTransformMatrix():void{
            if (this.layoutFeatures != null){
                if (this.layoutFeatures.is3D){
                    super.transform.matrix3D = this.layoutFeatures.computedMatrix3D;
                } else {
                    super.transform.matrix = this.layoutFeatures.computedMatrix;
                };
            };
        }

    }
}//package mx.core 
﻿package mx.core {
    import flash.display.*;
    import flash.geom.*;
    import flash.accessibility.*;
    import flash.events.*;

    public interface IFlexDisplayObject extends IBitmapDrawable, IEventDispatcher {

        function get root():DisplayObject;
        function get stage():Stage;
        function get name():String;
        function set name(_arg1:String):void;
        function get parent():DisplayObjectContainer;
        function get mask():DisplayObject;
        function set mask(_arg1:DisplayObject):void;
        function get visible():Boolean;
        function set visible(_arg1:Boolean):void;
        function get x():Number;
        function set x(_arg1:Number):void;
        function get y():Number;
        function set y(_arg1:Number):void;
        function get scaleX():Number;
        function set scaleX(_arg1:Number):void;
        function get scaleY():Number;
        function set scaleY(_arg1:Number):void;
        function get mouseX():Number;
        function get mouseY():Number;
        function get rotation():Number;
        function set rotation(_arg1:Number):void;
        function get alpha():Number;
        function set alpha(_arg1:Number):void;
        function get width():Number;
        function set width(_arg1:Number):void;
        function get height():Number;
        function set height(_arg1:Number):void;
        function get cacheAsBitmap():Boolean;
        function set cacheAsBitmap(_arg1:Boolean):void;
        function get opaqueBackground():Object;
        function set opaqueBackground(_arg1:Object):void;
        function get scrollRect():Rectangle;
        function set scrollRect(_arg1:Rectangle):void;
        function get filters():Array;
        function set filters(_arg1:Array):void;
        function get blendMode():String;
        function set blendMode(_arg1:String):void;
        function get transform():Transform;
        function set transform(_arg1:Transform):void;
        function get scale9Grid():Rectangle;
        function set scale9Grid(_arg1:Rectangle):void;
        function globalToLocal(_arg1:Point):Point;
        function localToGlobal(_arg1:Point):Point;
        function getBounds(_arg1:DisplayObject):Rectangle;
        function getRect(_arg1:DisplayObject):Rectangle;
        function get loaderInfo():LoaderInfo;
        function hitTestObject(_arg1:DisplayObject):Boolean;
        function hitTestPoint(_arg1:Number, _arg2:Number, _arg3:Boolean=false):Boolean;
        function get accessibilityProperties():AccessibilityProperties;
        function set accessibilityProperties(_arg1:AccessibilityProperties):void;
        function get measuredHeight():Number;
        function get measuredWidth():Number;
        function move(_arg1:Number, _arg2:Number):void;
        function setActualSize(_arg1:Number, _arg2:Number):void;

    }
}//package mx.core 
﻿package mx.core {

    public interface IRepeaterClient {

        function get instanceIndices():Array;
        function set instanceIndices(_arg1:Array):void;
        function get isDocument():Boolean;
        function get repeaterIndices():Array;
        function set repeaterIndices(_arg1:Array):void;
        function get repeaters():Array;
        function set repeaters(_arg1:Array):void;
        function initializeRepeaterArrays(_arg1:IRepeaterClient):void;

    }
}//package mx.core 
﻿package mx.utils {
    import flash.utils.*;
    import flash.display.*;
    import mx.core.*;

    public class NameUtil {

        mx_internal static const VERSION:String = "4.1.0.21490";

        private static var counter:int = 0;

        public static function createUniqueName(object:Object):String{
            if (!(object)){
                return (null);
            };
            var name:String = getQualifiedClassName(object);
            var index:int = name.indexOf("::");
            if (index != -1){
                name = name.substr((index + 2));
            };
            var charCode:int = name.charCodeAt((name.length - 1));
            if ((((charCode >= 48)) && ((charCode <= 57)))){
                name = (name + "_");
            };
            return ((name + counter++));
        }
        public static function displayObjectToString(displayObject:DisplayObject):String{
            var result:* = null;
            var o:* = null;
            var s:* = null;
            var indices:* = null;
            var displayObject:* = displayObject;
            try {
                o = displayObject;
                while (o != null) {
                    if (((((o.parent) && (o.stage))) && ((o.parent == o.stage)))){
                        break;
                    };
                    s = ((((("id" in o)) && (o["id"]))) ? o["id"] : o.name);
                    if ((o is IRepeaterClient)){
                        indices = IRepeaterClient(o).instanceIndices;
                        if (indices){
                            s = (s + (("[" + indices.join("][")) + "]"));
                        };
                    };
                    result = (((result == null)) ? s : ((s + ".") + result));
                    o = o.parent;
                };
            } catch(e:SecurityError) {
            };
            return (result);
        }
        public static function getUnqualifiedClassName(object:Object):String{
            var name:String;
            if ((object is String)){
                name = (object as String);
            } else {
                name = getQualifiedClassName(object);
            };
            var index:int = name.indexOf("::");
            if (index != -1){
                name = name.substr((index + 2));
            };
            return (name);
        }

    }
}//package mx.utils 
﻿package {
    import mx.core.*;

    public class Main_img003 extends BitmapAsset {

    }
}//package 
﻿package {
    import mx.core.*;

    public class Main_img002 extends BitmapAsset {

    }
}//package 
﻿package {
    import mx.core.*;

    public class Main_img_normal extends BitmapAsset {

    }
}//package 
﻿package lt.uza.ui {
    import flash.geom.*;
    import flash.display.*;

    public class Scale9BitmapSprite extends Sprite {

        private var topLeftCorner:Sprite;
        private var topRightCorner:Sprite;
        private var bottomLeftCorner:Sprite;
        private var bottomRightCorner:Sprite;
        private var topRectangle:Sprite;
        private var leftRectangle:Sprite;
        private var rightRectangle:Sprite;
        private var bottomRectangle:Sprite;
        private var mainRectangle:Sprite;
        private var verticalMarginSum:Number;
        private var horizontalMarginSum:Number;
        private var innerWidth:Number;
        private var innerHeight:Number;
        private var bd:BitmapData;
        private var sc:Rectangle;
        private var _TL:Rectangle;
        private var _TR:Rectangle;
        private var _BR:Rectangle;
        private var _BL:Rectangle;
        private var _T:Rectangle;
        private var _R:Rectangle;
        private var _B:Rectangle;
        private var _L:Rectangle;

        public function Scale9BitmapSprite(bitmapData:BitmapData, scale9rect:Rectangle){
            super();
            this.bd = bitmapData.clone();
            this.sc = scale9rect;
            var lx:Number = 0;
            var mx:Number = this.sc.x;
            var rx:Number = (this.sc.x + this.sc.width);
            var ty:Number = 0;
            var my:Number = this.sc.y;
            var by:Number = (this.sc.y + this.sc.height);
            var m_bottom:Number = (this.bd.height - by);
            var m_right:Number = (this.bd.width - rx);
            this.horizontalMarginSum = (this.bd.width - this.sc.width);
            this.verticalMarginSum = (this.bd.height - this.sc.height);
            this._TL = new Rectangle(0, 0, mx, this.sc.y);
            this._TR = new Rectangle(rx, 0, m_right, this.sc.y);
            this._BR = new Rectangle(rx, by, m_right, m_bottom);
            this._BL = new Rectangle(0, by, mx, m_bottom);
            this.topLeftCorner = this.createRectangle(this._TL);
            this.topRightCorner = this.createRectangle(this._TR);
            this.bottomRightCorner = this.createRectangle(this._BR);
            this.bottomLeftCorner = this.createRectangle(this._BL);
            this._T = new Rectangle(this.sc.x, 0, this.sc.width, this.sc.y);
            this._R = new Rectangle(rx, this.sc.y, m_right, this.sc.height);
            this._B = new Rectangle(this.sc.x, by, this.sc.width, m_bottom);
            this._L = new Rectangle(0, this.sc.y, mx, this.sc.height);
            this.topRectangle = this.createRectangle(this._T);
            this.rightRectangle = this.createRectangle(this._R);
            this.bottomRectangle = this.createRectangle(this._B);
            this.leftRectangle = this.createRectangle(this._L);
            this.mainRectangle = this.createRectangle(this.sc);
        }
        public function updateState(bitmapData:BitmapData):void{
            if ((((bitmapData.width == this.bd.width)) && ((bitmapData.height == this.bd.height)))){
                this.bd = bitmapData.clone();
                this.updateRectangle(this.topRectangle, this._T);
                this.updateRectangle(this.rightRectangle, this._R);
                this.updateRectangle(this.bottomRectangle, this._B);
                this.updateRectangle(this.leftRectangle, this._L);
                this.updateRectangle(this.topLeftCorner, this._TL);
                this.updateRectangle(this.topRightCorner, this._TR);
                this.updateRectangle(this.bottomRightCorner, this._BR);
                this.updateRectangle(this.bottomLeftCorner, this._BL);
                this.updateRectangle(this.mainRectangle, this.sc);
            } else {
                throw (new Error("New and old bitmapData dimensions must be equal"));
            };
        }
        override public function set width(width:Number):void{
            this.innerWidth = (width - this.horizontalMarginSum);
            this.topRectangle.width = (this.mainRectangle.width = (this.bottomRectangle.width = this.innerWidth));
            var newLeft:Number = (this.mainRectangle.x + this.mainRectangle.width);
            this.topRightCorner.x = newLeft;
            this.bottomRightCorner.x = newLeft;
            this.rightRectangle.x = newLeft;
        }
        override public function set height(height:Number):void{
            this.innerHeight = (height - this.verticalMarginSum);
            this.leftRectangle.height = (this.mainRectangle.height = (this.rightRectangle.height = this.innerHeight));
            var newTop:Number = (this.mainRectangle.y + this.mainRectangle.height);
            this.bottomLeftCorner.y = newTop;
            this.bottomRightCorner.y = newTop;
            this.bottomRectangle.y = newTop;
        }
        override public function set scaleX(scale:Number):void{
            this.topRectangle.scaleX = (this.mainRectangle.scaleX = (this.bottomRectangle.scaleX = scale));
            var newLeft:Number = (this.mainRectangle.x + this.mainRectangle.width);
            this.topRightCorner.x = newLeft;
            this.bottomRightCorner.x = newLeft;
            this.rightRectangle.x = newLeft;
        }
        override public function get scaleX():Number{
            return (this.mainRectangle.scaleX);
        }
        override public function set scaleY(scale:Number):void{
            this.leftRectangle.scaleY = (this.mainRectangle.scaleY = (this.rightRectangle.scaleY = scale));
            var newTop:Number = (this.mainRectangle.y + this.mainRectangle.height);
            this.bottomLeftCorner.y = newTop;
            this.bottomRightCorner.y = newTop;
            this.bottomRectangle.y = newTop;
        }
        override public function get scaleY():Number{
            return (this.mainRectangle.scaleY);
        }
        private function updateRectangle(sprite:Sprite, rect:Rectangle):void{
            var sprite:* = sprite;
            var rect:* = rect;
            var xPos:* = rect.x;
            var yPos:* = rect.y;
            var w:* = rect.width;
            var h:* = rect.height;
            var move:* = new Matrix();
            move.translate(-(xPos), -(yPos));
            var _local4 = sprite.graphics;
            with (_local4) {
                clear();
                beginBitmapFill(bd, move, false);
                drawRect(0, 0, w, h);
                endFill();
            };
        }
        private function createRectangle(rect:Rectangle):Sprite{
            var xPos:Number = rect.x;
            var yPos:Number = rect.y;
            var w:Number = rect.width;
            var h:Number = rect.height;
            var sprite:Sprite = new Sprite();
            var move:Matrix = new Matrix();
            move.translate(-(xPos), -(yPos));
            sprite.graphics.beginBitmapFill(this.bd, move, false);
            sprite.graphics.drawRect(0, 0, w, h);
            sprite.graphics.endFill();
            sprite.x = xPos;
            sprite.y = yPos;
            addChild(sprite);
            return (sprite);
        }

    }
}//package lt.uza.ui 
﻿package com.adobe.serialization.json {

    public class JSONToken {

        private var _type:int;
        private var _value:Object;

        public function JSONToken(type:int=-1, value:Object=null){
            super();
            this._type = type;
            this._value = value;
        }
        public function get type():int{
            return (this._type);
        }
        public function set type(value:int):void{
            this._type = value;
        }
        public function get value():Object{
            return (this._value);
        }
        public function set value(v:Object):void{
            this._value = v;
        }

    }
}//package com.adobe.serialization.json 
﻿package com.adobe.serialization.json {
    import flash.utils.*;

    public class JSONEncoder {

        private var jsonString:String;

        public function JSONEncoder(value){
            super();
            this.jsonString = this.convertToString(value);
        }
        public function getString():String{
            return (this.jsonString);
        }
        private function convertToString(value):String{
            if ((value is String)){
                return (this.escapeString((value as String)));
            };
            if ((value is Number)){
                return (((isFinite((value as Number))) ? value.toString() : "null"));
            };
            if ((value is Boolean)){
                return (((value) ? "true" : "false"));
            };
            if ((value is Array)){
                return (this.arrayToString((value as Array)));
            };
            if ((((value is Object)) && (!((value == null))))){
                return (this.objectToString(value));
            };
            return ("null");
        }
        private function escapeString(str:String):String{
            var ch:String;
            var hexCode:String;
            var zeroPad:String;
            var s:String = "";
            var len:Number = str.length;
            var i:int;
            while (i < len) {
                ch = str.charAt(i);
                switch (ch){
                    case "\"":
                        s = (s + "\\\"");
                        break;
                    case "\\":
                        s = (s + "\\\\");
                        break;
                    case "\b":
                        s = (s + "\\b");
                        break;
                    case "\f":
                        s = (s + "\\f");
                        break;
                    case "\n":
                        s = (s + "\\n");
                        break;
                    case "\r":
                        s = (s + "\\r");
                        break;
                    case "\t":
                        s = (s + "\\t");
                        break;
                    default:
                        if (ch < " "){
                            hexCode = ch.charCodeAt(0).toString(16);
                            zeroPad = (((hexCode.length == 2)) ? "00" : "000");
                            s = (s + (("\\u" + zeroPad) + hexCode));
                        } else {
                            s = (s + ch);
                        };
                };
                i++;
            };
            return ((("\"" + s) + "\""));
        }
        private function arrayToString(a:Array):String{
            var s:String = "";
            var i:int;
            while (i < a.length) {
                if (s.length > 0){
                    s = (s + ",");
                };
                s = (s + this.convertToString(a[i]));
                i++;
            };
            return ((("[" + s) + "]"));
        }
        private function objectToString(o:Object):String{
            var value:* = null;
            var key:* = null;
            var v:* = null;
            var o:* = o;
            var s:* = "";
            var classInfo:* = describeType(o);
            if (classInfo.@name.toString() == "Object"){
                for (key in o) {
                    value = o[key];
                    if ((value is Function)){
                    } else {
                        if (s.length > 0){
                            s = (s + ",");
                        };
                        s = (s + ((this.escapeString(key) + ":") + this.convertToString(value)));
                    };
                };
            } else {
                var _local3:int;
                var _local6:int;
                var _local7:* = classInfo..*;
                var _local5 = new XMLList("");
                for each (var _local8 in classInfo..*) {
                    var _local9 = _local8;
                    with (_local9) {
                        if ((((name() == "variable")) || ((((name() == "accessor")) && ((attribute("access").charAt(0) == "r")))))){
                            _local5[_local6] = _local8;
                        };
                    };
                };
                var _local4:* = _local5;
                for each (v in _local5) {
                    if (((v.metadata) && ((v.metadata.(@name == "Transient").length() > 0)))){
                    } else {
                        if (s.length > 0){
                            s = (s + ",");
                        };
                        s = (s + ((this.escapeString(v.@name.toString()) + ":") + this.convertToString(o[v.@name])));
                    };
                };
            };
            return ((("{" + s) + "}"));
        }

    }
}//package com.adobe.serialization.json 
﻿package com.adobe.serialization.json {

    public class JSONParseError extends Error {

        private var _location:int;
        private var _text:String;

        public function JSONParseError(message:String="", location:int=0, text:String=""){
            super(message);
            name = "JSONParseError";
            this._location = location;
            this._text = text;
        }
        public function get location():int{
            return (this._location);
        }
        public function get text():String{
            return (this._text);
        }

    }
}//package com.adobe.serialization.json 
﻿package com.adobe.serialization.json {

    public class JSONTokenizer {

        private var strict:Boolean;
        private var obj:Object;
        private var jsonString:String;
        private var loc:int;
        private var ch:String;
        private var controlCharsRegExp:RegExp;

        public function JSONTokenizer(s:String, strict:Boolean){
            this.controlCharsRegExp = /[\x00-\x1F]/;
            super();
            this.jsonString = s;
            this.strict = strict;
            this.loc = 0;
            this.nextChar();
        }
        public function getNextToken():JSONToken{
            var _local2:String;
            var _local3:String;
            var _local4:String;
            var _local5:String;
            var token:JSONToken = new JSONToken();
            this.skipIgnored();
            switch (this.ch){
                case "{":
                    token.type = JSONTokenType.LEFT_BRACE;
                    token.value = "{";
                    this.nextChar();
                    break;
                case "}":
                    token.type = JSONTokenType.RIGHT_BRACE;
                    token.value = "}";
                    this.nextChar();
                    break;
                case "[":
                    token.type = JSONTokenType.LEFT_BRACKET;
                    token.value = "[";
                    this.nextChar();
                    break;
                case "]":
                    token.type = JSONTokenType.RIGHT_BRACKET;
                    token.value = "]";
                    this.nextChar();
                    break;
                case ",":
                    token.type = JSONTokenType.COMMA;
                    token.value = ",";
                    this.nextChar();
                    break;
                case ":":
                    token.type = JSONTokenType.COLON;
                    token.value = ":";
                    this.nextChar();
                    break;
                case "t":
                    _local2 = ((("t" + this.nextChar()) + this.nextChar()) + this.nextChar());
                    if (_local2 == "true"){
                        token.type = JSONTokenType.TRUE;
                        token.value = true;
                        this.nextChar();
                    } else {
                        this.parseError(("Expecting 'true' but found " + _local2));
                    };
                    break;
                case "f":
                    _local3 = (((("f" + this.nextChar()) + this.nextChar()) + this.nextChar()) + this.nextChar());
                    if (_local3 == "false"){
                        token.type = JSONTokenType.FALSE;
                        token.value = false;
                        this.nextChar();
                    } else {
                        this.parseError(("Expecting 'false' but found " + _local3));
                    };
                    break;
                case "n":
                    _local4 = ((("n" + this.nextChar()) + this.nextChar()) + this.nextChar());
                    if (_local4 == "null"){
                        token.type = JSONTokenType.NULL;
                        token.value = null;
                        this.nextChar();
                    } else {
                        this.parseError(("Expecting 'null' but found " + _local4));
                    };
                    break;
                case "N":
                    _local5 = (("N" + this.nextChar()) + this.nextChar());
                    if (_local5 == "NaN"){
                        token.type = JSONTokenType.NAN;
                        token.value = NaN;
                        this.nextChar();
                    } else {
                        this.parseError(("Expecting 'NaN' but found " + _local5));
                    };
                    break;
                case "\"":
                    token = this.readString();
                    break;
                default:
                    if (((this.isDigit(this.ch)) || ((this.ch == "-")))){
                        token = this.readNumber();
                    } else {
                        if (this.ch == ""){
                            return (null);
                        };
                        this.parseError((("Unexpected " + this.ch) + " encountered"));
                    };
            };
            return (token);
        }
        private function readString():JSONToken{
            var backspaceCount:int;
            var backspaceIndex:int;
            var quoteIndex:int = this.loc;
            do  {
                quoteIndex = this.jsonString.indexOf("\"", quoteIndex);
                if (quoteIndex >= 0){
                    backspaceCount = 0;
                    backspaceIndex = (quoteIndex - 1);
                    while (this.jsonString.charAt(backspaceIndex) == "\\") {
                        backspaceCount++;
                        backspaceIndex--;
                    };
                    if ((backspaceCount % 2) == 0){
                        break;
                    };
                    quoteIndex++;
                } else {
                    this.parseError("Unterminated string literal");
                };
            } while (true);
            var token:JSONToken = new JSONToken();
            token.type = JSONTokenType.STRING;
            token.value = this.unescapeString(this.jsonString.substr(this.loc, (quoteIndex - this.loc)));
            this.loc = (quoteIndex + 1);
            this.nextChar();
            return (token);
        }
        public function unescapeString(input:String):String{
            var afterBackslashIndex:int;
            var escapedChar:String;
            var _local8:String;
            var i:int;
            var possibleHexChar:String;
            if (((this.strict) && (this.controlCharsRegExp.test(input)))){
                this.parseError("String contains unescaped control character (0x00-0x1F)");
            };
            var result:String = "";
            var backslashIndex:int;
            var nextSubstringStartPosition:int;
            var len:int = input.length;
            do  {
                backslashIndex = input.indexOf("\\", nextSubstringStartPosition);
                if (backslashIndex >= 0){
                    result = (result + input.substr(nextSubstringStartPosition, (backslashIndex - nextSubstringStartPosition)));
                    nextSubstringStartPosition = (backslashIndex + 2);
                    afterBackslashIndex = (backslashIndex + 1);
                    escapedChar = input.charAt(afterBackslashIndex);
                    switch (escapedChar){
                        case "\"":
                            result = (result + "\"");
                            break;
                        case "\\":
                            result = (result + "\\");
                            break;
                        case "n":
                            result = (result + "\n");
                            break;
                        case "r":
                            result = (result + "\r");
                            break;
                        case "t":
                            result = (result + "\t");
                            break;
                        case "u":
                            _local8 = "";
                            if ((nextSubstringStartPosition + 4) > len){
                                this.parseError("Unexpected end of input.  Expecting 4 hex digits after \\u.");
                            };
                            i = nextSubstringStartPosition;
                            while (i < (nextSubstringStartPosition + 4)) {
                                possibleHexChar = input.charAt(i);
                                if (!(this.isHexDigit(possibleHexChar))){
                                    this.parseError(("Excepted a hex digit, but found: " + possibleHexChar));
                                };
                                _local8 = (_local8 + possibleHexChar);
                                i++;
                            };
                            result = (result + String.fromCharCode(parseInt(_local8, 16)));
                            nextSubstringStartPosition = (nextSubstringStartPosition + 4);
                            break;
                        case "f":
                            result = (result + "\f");
                            break;
                        case "/":
                            result = (result + "/");
                            break;
                        case "b":
                            result = (result + "\b");
                            break;
                        default:
                            result = (result + ("\\" + escapedChar));
                    };
                } else {
                    result = (result + input.substr(nextSubstringStartPosition));
                    break;
                };
            } while (nextSubstringStartPosition < len);
            return (result);
        }
        private function readNumber():JSONToken{
            var token:JSONToken;
            var input:String = "";
            if (this.ch == "-"){
                input = (input + "-");
                this.nextChar();
            };
            if (!(this.isDigit(this.ch))){
                this.parseError("Expecting a digit");
            };
            if (this.ch == "0"){
                input = (input + this.ch);
                this.nextChar();
                if (this.isDigit(this.ch)){
                    this.parseError("A digit cannot immediately follow 0");
                } else {
                    if (((!(this.strict)) && ((this.ch == "x")))){
                        input = (input + this.ch);
                        this.nextChar();
                        if (this.isHexDigit(this.ch)){
                            input = (input + this.ch);
                            this.nextChar();
                        } else {
                            this.parseError("Number in hex format require at least one hex digit after \"0x\"");
                        };
                        while (this.isHexDigit(this.ch)) {
                            input = (input + this.ch);
                            this.nextChar();
                        };
                    };
                };
            } else {
                while (this.isDigit(this.ch)) {
                    input = (input + this.ch);
                    this.nextChar();
                };
            };
            if (this.ch == "."){
                input = (input + ".");
                this.nextChar();
                if (!(this.isDigit(this.ch))){
                    this.parseError("Expecting a digit");
                };
                while (this.isDigit(this.ch)) {
                    input = (input + this.ch);
                    this.nextChar();
                };
            };
            if ((((this.ch == "e")) || ((this.ch == "E")))){
                input = (input + "e");
                this.nextChar();
                if ((((this.ch == "+")) || ((this.ch == "-")))){
                    input = (input + this.ch);
                    this.nextChar();
                };
                if (!(this.isDigit(this.ch))){
                    this.parseError("Scientific notation number needs exponent value");
                };
                while (this.isDigit(this.ch)) {
                    input = (input + this.ch);
                    this.nextChar();
                };
            };
            var num:Number = Number(input);
            if (((isFinite(num)) && (!(isNaN(num))))){
                token = new JSONToken();
                token.type = JSONTokenType.NUMBER;
                token.value = num;
                return (token);
            };
            this.parseError((("Number " + num) + " is not valid!"));
            return (null);
        }
        private function nextChar():String{
            return ((this.ch = this.jsonString.charAt(this.loc++)));
        }
        private function skipIgnored():void{
            var originalLoc:int;
            do  {
                originalLoc = this.loc;
                this.skipWhite();
                this.skipComments();
            } while (originalLoc != this.loc);
        }
        private function skipComments():void{
            if (this.ch == "/"){
                this.nextChar();
                switch (this.ch){
                    case "/":
                        do  {
                            this.nextChar();
                        } while (((!((this.ch == "\n"))) && (!((this.ch == "")))));
                        this.nextChar();
                        break;
                    case "*":
                        this.nextChar();
                        while (true) {
                            if (this.ch == "*"){
                                this.nextChar();
                                if (this.ch == "/"){
                                    this.nextChar();
                                    break;
                                };
                            } else {
                                this.nextChar();
                            };
                            if (this.ch == ""){
                                this.parseError("Multi-line comment not closed");
                            };
                        };
                        break;
                    default:
                        this.parseError((("Unexpected " + this.ch) + " encountered (expecting '/' or '*' )"));
                };
            };
        }
        private function skipWhite():void{
            while (this.isWhiteSpace(this.ch)) {
                this.nextChar();
            };
        }
        private function isWhiteSpace(ch:String):Boolean{
            if ((((((((ch == " ")) || ((ch == "\t")))) || ((ch == "\n")))) || ((ch == "\r")))){
                return (true);
            };
            if (((!(this.strict)) && ((ch.charCodeAt(0) == 160)))){
                return (true);
            };
            return (false);
        }
        private function isDigit(ch:String):Boolean{
            return ((((ch >= "0")) && ((ch <= "9"))));
        }
        private function isHexDigit(ch:String):Boolean{
            return (((((this.isDigit(ch)) || ((((ch >= "A")) && ((ch <= "F")))))) || ((((ch >= "a")) && ((ch <= "f"))))));
        }
        public function parseError(message:String):void{
            throw (new JSONParseError(message, this.loc, this.jsonString));
        }

    }
}//package com.adobe.serialization.json 
﻿package com.adobe.serialization.json {

    public class JSONTokenType {

        public static const UNKNOWN:int = -1;
        public static const COMMA:int = 0;
        public static const LEFT_BRACE:int = 1;
        public static const RIGHT_BRACE:int = 2;
        public static const LEFT_BRACKET:int = 3;
        public static const RIGHT_BRACKET:int = 4;
        public static const COLON:int = 6;
        public static const TRUE:int = 7;
        public static const FALSE:int = 8;
        public static const NULL:int = 9;
        public static const STRING:int = 10;
        public static const NUMBER:int = 11;
        public static const NAN:int = 12;

    }
}//package com.adobe.serialization.json 
﻿package com.adobe.serialization.json {

    public class JSONDecoder {

        private var strict:Boolean;
        private var value;
        private var tokenizer:JSONTokenizer;
        private var token:JSONToken;

        public function JSONDecoder(s:String, strict:Boolean){
            super();
            this.strict = strict;
            this.tokenizer = new JSONTokenizer(s, strict);
            this.nextToken();
            this.value = this.parseValue();
            if (((strict) && (!((this.nextToken() == null))))){
                this.tokenizer.parseError("Unexpected characters left in input stream");
            };
        }
        public function getValue(){
            return (this.value);
        }
        private function nextToken():JSONToken{
            return ((this.token = this.tokenizer.getNextToken()));
        }
        private function parseArray():Array{
            var a:Array = new Array();
            this.nextToken();
            if (this.token.type == JSONTokenType.RIGHT_BRACKET){
                return (a);
            };
            if (((!(this.strict)) && ((this.token.type == JSONTokenType.COMMA)))){
                this.nextToken();
                if (this.token.type == JSONTokenType.RIGHT_BRACKET){
                    return (a);
                };
                this.tokenizer.parseError(("Leading commas are not supported.  Expecting ']' but found " + this.token.value));
            };
            while (true) {
                a.push(this.parseValue());
                this.nextToken();
                if (this.token.type == JSONTokenType.RIGHT_BRACKET){
                    return (a);
                };
                if (this.token.type == JSONTokenType.COMMA){
                    this.nextToken();
                    if (!(this.strict)){
                        if (this.token.type == JSONTokenType.RIGHT_BRACKET){
                            return (a);
                        };
                    };
                } else {
                    this.tokenizer.parseError(("Expecting ] or , but found " + this.token.value));
                };
            };
            return (null);
        }
        private function parseObject():Object{
            var key:String;
            var o:Object = new Object();
            this.nextToken();
            if (this.token.type == JSONTokenType.RIGHT_BRACE){
                return (o);
            };
            if (((!(this.strict)) && ((this.token.type == JSONTokenType.COMMA)))){
                this.nextToken();
                if (this.token.type == JSONTokenType.RIGHT_BRACE){
                    return (o);
                };
                this.tokenizer.parseError(("Leading commas are not supported.  Expecting '}' but found " + this.token.value));
            };
            while (true) {
                if (this.token.type == JSONTokenType.STRING){
                    key = String(this.token.value);
                    this.nextToken();
                    if (this.token.type == JSONTokenType.COLON){
                        this.nextToken();
                        o[key] = this.parseValue();
                        this.nextToken();
                        if (this.token.type == JSONTokenType.RIGHT_BRACE){
                            return (o);
                        };
                        if (this.token.type == JSONTokenType.COMMA){
                            this.nextToken();
                            if (!(this.strict)){
                                if (this.token.type == JSONTokenType.RIGHT_BRACE){
                                    return (o);
                                };
                            };
                        } else {
                            this.tokenizer.parseError(("Expecting } or , but found " + this.token.value));
                        };
                    } else {
                        this.tokenizer.parseError(("Expecting : but found " + this.token.value));
                    };
                } else {
                    this.tokenizer.parseError(("Expecting string but found " + this.token.value));
                };
            };
            return (null);
        }
        private function parseValue():Object{
            if (this.token == null){
                this.tokenizer.parseError("Unexpected end of input");
            };
            switch (this.token.type){
                case JSONTokenType.LEFT_BRACE:
                    return (this.parseObject());
                case JSONTokenType.LEFT_BRACKET:
                    return (this.parseArray());
                case JSONTokenType.STRING:
                case JSONTokenType.NUMBER:
                case JSONTokenType.TRUE:
                case JSONTokenType.FALSE:
                case JSONTokenType.NULL:
                    return (this.token.value);
                case JSONTokenType.NAN:
                    if (!(this.strict)){
                        return (this.token.value);
                    };
                    this.tokenizer.parseError(("Unexpected " + this.token.value));
                default:
                    this.tokenizer.parseError(("Unexpected " + this.token.value));
            };
            return (null);
        }

    }
}//package com.adobe.serialization.json 
﻿package com.onez.skin {
    import flash.text.*;

    public class Label extends OnezSprite {

        public var t:TextField;

        public function Label(text:String, color:uint=4276547, alignOrSize="left", tf:TextFormat=null, multiline:Boolean=false){
            super();
            if (tf == null){
                tf = new TextFormat();
                tf.size = 12;
            };
            this.mouseEnabled = true;
            this.t = new TextField();
            this.t.selectable = false;
            this.t.mouseEnabled = true;
            this.t.textColor = color;
            if ((alignOrSize is String)){
                this.t.autoSize = alignOrSize;
            } else {
                if ((alignOrSize is Number)){
                    this.t.autoSize = "left";
                    this.t.width = alignOrSize;
                    this.t.selectable = true;
                    this.t.wordWrap = true;
                    this.t.multiline = true;
                };
            };
            this.t.multiline = multiline;
            this.t.defaultTextFormat = tf;
            this.t.htmlText = ((text) ? text : "");
            addChild(this.t);
        }
        public function set text(v:String):void{
            this.t.htmlText = ((v) ? v : "");
        }
        public function get text():String{
            return (this.t.htmlText);
        }
        public function get color():uint{
            return (this.t.textColor);
        }
        public function set color(value:uint):void{
            this.t.textColor = value;
        }

    }
}//package com.onez.skin 
﻿package com.onez.skin {
    import flash.events.*;
    import com.onez.common.*;
    import flash.text.*;
    import flash.display.*;
    import flash.filters.*;
    import com.greensock.*;
    import flash.utils.*;
    import flash.net.*;

    public class OnezSprite extends Sprite {

        private static const titleOffset:Number = 15;

        private var current:Sprite;
        private var _exit:Boolean = false;
        private var _title:String;
        private var titleTimer:String;
        private var _loads:Object;
        private var _timers:Object;
        private var _exitTimer:uint = 0;

        public function OnezSprite(){
            this._loads = {};
            this._timers = {};
            super();
            if (stage){
                this.stageInit();
            } else {
                addEventListener(Event.ENTER_FRAME, this.stageInit);
            };
        }
        private function stageInit(e:Event=null):void{
            if (stage == null){
                return;
            };
            removeEventListener(Event.ENTER_FRAME, this.stageInit);
            this.init();
        }
        public function init():void{
        }
        public function get title():String{
            return (this._title);
        }
        public function set title(value:String):void{
            this._title = value;
            removeEventListener(MouseEvent.MOUSE_OVER, this.targetHandler);
            removeEventListener(MouseEvent.MOUSE_OUT, this.targetHandler);
            if (value == ""){
                if (this.current != null){
                    stage.removeChild(this.current);
                    this.current = null;
                };
            } else {
                addEventListener(MouseEvent.MOUSE_OVER, this.targetHandler);
                addEventListener(MouseEvent.MOUSE_OUT, this.targetHandler);
                addEventListener(MouseEvent.MOUSE_MOVE, this.targetHandler);
            };
        }
        private function setTitlePos():void{
            if (this.current != null){
                if (((((stage.mouseX - (this.current.width / 2)) > 0)) && (((stage.mouseX + (this.current.width / 2)) < Onez.info.width)))){
                    this.current.x = (stage.mouseX + 15);
                } else {
                    if (((stage.mouseX + this.current.width) + titleOffset) > Onez.info.width){
                        this.current.x = ((stage.mouseX - this.current.width) - titleOffset);
                    } else {
                        this.current.x = (stage.mouseX + titleOffset);
                    };
                };
                if ((((stage.mouseY + this.current.height) + titleOffset) + 0) > Onez.info.height){
                    this.current.y = ((stage.mouseY - this.current.height) - titleOffset);
                } else {
                    this.current.y = (stage.mouseY + titleOffset);
                };
                if (this.titleTimer){
                    this._clearTimeout(this.titleTimer);
                };
                this.titleTimer = this._setTimeout(Delegate.create(this.removeTitle, this.current), 3000);
                if (((!((this.current == null))) && (!((this.current.parent == null))))){
                    this.current.visible = true;
                    this.current.alpha = 1;
                };
            };
        }
        private function targetHandler(e:MouseEvent):void{
            var _local2:TextField;
            if (stage == null){
                return;
            };
            switch (e.type){
                case MouseEvent.MOUSE_OVER:
                    this.current = new Sprite();
                    _local2 = new TextField();
                    _local2.autoSize = TextFieldAutoSize.LEFT;
                    _local2.x = 0;
                    _local2.multiline = true;
                    _local2.htmlText = this._title;
                    this.current.addChild(_local2);
                    this.current.graphics.lineStyle(1, 0, 1, true);
                    this.current.graphics.beginFill(16777185, 1);
                    this.current.graphics.drawRect(-2, -2, (_local2.textWidth + 6), (_local2.textHeight + 6));
                    this.current.graphics.endFill();
                    this.current.filters = [new DropShadowFilter(4, 45, 0, 0.5)];
                    this.setTitlePos();
                    stage.addChild(this.current);
                    break;
                case MouseEvent.MOUSE_OUT:
                    if (this.titleTimer){
                        this._clearTimeout(this.titleTimer);
                    };
                    if (((!((this.current == null))) && (!((this.current.parent == null))))){
                        this.current.parent.removeChild(this.current);
                        this.current = null;
                    };
                    break;
                case MouseEvent.MOUSE_MOVE:
                    this.setTitlePos();
                    break;
            };
        }
        private function removeTitle(s:Sprite):void{
            if (((!((s == null))) && (!((s.parent == null))))){
                TweenLite.to(s, 1, {
                    alpha:0,
                    onComplete:Delegate.create(this.clearTitle, s)
                });
            };
        }
        private function clearTitle(s:Sprite):void{
            if (((!((s == null))) && (!((s.parent == null))))){
                s.parent.removeChild(s);
                s = null;
            };
        }
        public function _setTimeout(closure:Function, delay:Number):String{
            if (this.exit){
                return ("");
            };
            var token:String = ("time" + Math.random());
            var index:uint = setTimeout(Delegate.create(this._funcTimeout, closure, token), delay);
            this._timers[token] = index;
            return (token);
        }
        public function _clearTimeout(token:String):void{
            if (token == null){
                return;
            };
            if (typeof(this._timers[token]) != "undefined"){
                clearTimeout(this._timers[token]);
                delete this._timers[token];
            };
        }
        private function _funcTimeout(closure:Function, token:String):void{
            if (typeof(this._timers[token]) != "undefined"){
                delete this._timers[token];
            };
            if (this.exit){
                trace("_funcTimeout exit");
                return;
            };
            closure();
        }
        public function _Loader(url, complete:Function=null, ioerror:Function=null, progress:Function=null):void{
            if (this.exit){
                trace("_Loader exit");
                return;
            };
            var token:String = ("loader" + Math.random());
            var loader:Loader = new Loader();
            loader.cacheAsBitmap = true;
            loader.contentLoaderInfo.addEventListener(IOErrorEvent.IO_ERROR, Delegate.create(this._loaderHandler, ioerror, token));
            loader.contentLoaderInfo.addEventListener(Event.COMPLETE, Delegate.create(this._loaderHandler, complete, token));
            if (progress != null){
                loader.contentLoaderInfo.addEventListener(ProgressEvent.PROGRESS, progress);
            };
            if ((url is ByteArray)){
                loader.loadBytes(url);
                this._loads[token] = loader;
            } else {
                if ((url is String)){
                    loader.load(new URLRequest(url));
                };
            };
        }
        private function _loaderHandler(e:Event, func:Function, token:String):void{
            if ((((e.type == IOErrorEvent.IO_ERROR)) || ((e.type == Event.COMPLETE)))){
                delete this._timers[token];
            };
            if (this.exit){
                trace("_loaderHandler exit");
                return;
            };
            if (func != null){
                func(e);
            };
        }
        public function get main():Main{
            return (Onez.main);
        }
        public function get exit():Boolean{
            return (this._exit);
        }
        public function set exit(value:Boolean):void{
            var k:String;
            this._exit = value;
            if (this._exit){
                this._exitTimer = setInterval(this.checkExit, 100);
                for (k in this._timers) {
                    clearTimeout(this._timers[k]);
                };
            };
        }
        private function checkExit():void{
            var k:String;
            for (k in this._loads) {
                break;
            };
            for (k in this._timers) {
                break;
            };
            clearInterval(this._exitTimer);
            if (this.parent != null){
                this.parent.removeChild(this);
            };
        }

    }
}//package com.onez.skin 
﻿package com.onez.common {
    import flash.net.*;
    import flash.display.*;
    import com.adobe.serialization.json.*;
    import flash.utils.*;
    import flash.geom.*;

    public final class Onez {

        public static var main;
        public static var stage:Stage;
        public static var info:Object = {};
        public static var last:Object = {};
        public static var pic:Object = {};
        public static var flashs:Object = {};
        public static var vip:Boolean = false;
        public static var mode:String = "make";
        public static var baseSize:Array = [];
        public static var swf_loading:Class;
        private static var so:SharedObject = SharedObject.getLocal("onez-cookie");

        public static function init(stage:Stage, main, url:String=null):void{
            var swfurl:String;
            Onez.stage = stage;
            Onez.main = main;
            if (stage){
                Onez.info = stage.loaderInfo.parameters;
                stage.align = StageAlign.TOP_LEFT;
                stage.scaleMode = StageScaleMode.NO_SCALE;
            };
            if (url){
                swfurl = url;
                if (swfurl.indexOf("/source/plugin/") != -1){
                    Onez.info.siteurl = url.split("/source/plugin/")[0];
                    Onez.info.resurl = (Onez.info.siteurl + "/source/plugin/onez_kefu/template");
                    Onez.info.apiurl = (Onez.info.siteurl + "/plugin.php?id=onez_kefu&from=flash");
                } else {
                    if (swfurl.indexOf("/res/") != -1){
                        Onez.info.siteurl = url.split("/res/")[0];
                        Onez.info.resurl = Onez.info.siteurl;
                        Onez.info.apiurl = (Onez.info.siteurl + "/onez.php?from=flash");
                    } else {
                        Onez.info.siteurl = url;
                        Onez.info.resurl = Onez.info.siteurl;
                        Onez.info.apiurl = (Onez.info.siteurl + "/onez.php?from=flash");
                    };
                };
            };
        }
        public static function get cookie():Object{
            var _cookie:Object;
            if (typeof(so.data.cookie) == "undefined"){
                _cookie = {};
                so.data.cookie = _cookie;
            } else {
                _cookie = so.data.cookie;
            };
            return (_cookie);
        }
        public static function set cookie(value:Object):void{
            var k:String;
            if (typeof(so.data.cookie) == "undefined"){
                so.data.cookie = {};
            };
            if (value != null){
                for (k in value) {
                    so.data.cookie[k] = value[k];
                };
            };
        }
        public static function ApiUrl(s:String):String{
            return ((((Onez.option("apiurl") + s) + "&t=") + Math.random()));
        }
        public static function toJSON(s:String):Object{
            var s:* = s;
            var o:* = {};
            try {
                o = new JSONDecoder(s, true).getValue();
            } catch(e:Error) {
            };
            return (o);
        }
        public static function toString(s):String{
            if (typeof(s) == "object"){
                return (new JSONEncoder(s).getString());
            };
            if (typeof(s) == "string"){
                return (s.toString());
            };
            return ("");
        }
        public static function gbk2utf8(s:String):String{
            var byte:ByteArray = new ByteArray();
            byte.writeMultiByte(s, "GBK");
            byte.position = 0;
            return (s);
        }
        public static function utf82gbk(s:String):String{
            var byte:ByteArray = new ByteArray();
            byte.writeMultiByte(s, "UTF-8");
            byte.position = 0;
            return (byte.readMultiByte(byte.length, "GBK"));
        }
        public static function openUrl(url:String, target:String="_blank"):void{
            navigateToURL(new URLRequest(url), target);
        }
        public static function getSize(pic:BitmapData, maxWidth:Number, maxHeight:Number):Array{
            var w:Number = pic.width;
            var h:Number = pic.height;
            if (w > maxWidth){
                w = maxWidth;
                h = ((w * pic.height) / pic.width);
            };
            if (h > maxHeight){
                h = maxHeight;
                w = ((h * pic.width) / pic.height);
            };
            return ([w, h]);
        }
        public static function getSizeArr(tw:Number, th:Number, maxWidth:Number, maxHeight:Number):Array{
            var w:Number = tw;
            var h:Number = th;
            if (w > maxWidth){
                w = maxWidth;
                h = ((w * th) / tw);
            };
            if (h > maxHeight){
                h = maxHeight;
                w = ((h * tw) / th);
            };
            return ([w, h]);
        }
        public static function getSizePic(pic:BitmapData, maxWidth:Number, maxHeight:Number):BitmapData{
            var w:Number = pic.width;
            var h:Number = pic.height;
            if (w > maxWidth){
                w = maxWidth;
                h = ((w * pic.height) / pic.width);
            };
            if (h > maxHeight){
                h = maxHeight;
                w = ((h * pic.width) / pic.height);
            };
            var temp:BitmapData = new BitmapData(w, h, true, 0xFFFFFF);
            temp.draw(pic, new Matrix((w / pic.width), 0, 0, (h / pic.height)), null, null, null, true);
            return (temp);
        }
        public static function getRectPic(pic:BitmapData, maxWidth:Number, maxHeight:Number):BitmapData{
            var w:Number = (pic.width / 100);
            var h:Number = (pic.height / 100);
            if (w < maxWidth){
                w = maxWidth;
                h = ((w * pic.height) / pic.width);
            };
            if (h < maxHeight){
                h = maxHeight;
                w = ((h * pic.width) / pic.height);
            };
            var temp:BitmapData = new BitmapData(maxWidth, maxHeight, true, 0xFFFFFF);
            temp.draw(pic, new Matrix((w / pic.width), 0, 0, (h / pic.height), 0, 0), null, null, null, true);
            return (temp);
        }
        public static function getRectArr(tw:Number, th:Number, maxWidth:Number, maxHeight:Number):Array{
            var w:Number = (tw / 100);
            var h:Number = (th / 100);
            if (w < maxWidth){
                w = maxWidth;
                h = ((w * th) / tw);
            };
            if (h < maxHeight){
                h = maxHeight;
                w = ((h * tw) / th);
            };
            return ([w, h]);
        }
        public static function number_format(t:int, len:int=2):String{
            return (("0000" + t).substr(-(len)));
        }
        public static function time_format(sec:int):String{
            var t:int = sec;
            var s:String = "";
            s = ((":" + number_format((t % 60))) + s);
            t = Math.floor((t / 60));
            s = ((":" + number_format((t % 60))) + s);
            t = Math.floor((t / 60));
            s = (number_format((t % 60)) + s);
            return (s);
        }
        public static function removeAll(box):void{
            var i:int = (box.numChildren - 1);
            while (i >= 0) {
                box.removeChildAt(i);
                i--;
            };
        }
        public static function Now():String{
            var date:Date = new Date();
            var Y_:String = date.fullYear.toString();
            var m_:String = date.month.toString();
            var d_:String = date.day.toString();
            if (m_.length == 1){
                m_ = ("0" + m_);
            };
            if (d_.length == 1){
                d_ = ("0" + d_);
            };
            var H_:String = date.getHours().toString();
            var i_:String = date.getMinutes().toString();
            var s_:String = date.getSeconds().toString();
            if (i_.length == 1){
                i_ = ("0" + i_);
            };
            if (s_.length == 1){
                s_ = ("0" + s_);
            };
            return (((((H_ + ":") + i_) + ":") + s_));
        }
        public static function getLineX(width:Number, color:uint=9284340, alpha:Number=1, x:Number=0):Sprite{
            var b:Shape = new Shape();
            b.graphics.beginFill(color, alpha);
            b.graphics.drawRect(0, 0, 1, 1);
            b.graphics.endFill();
            var bitmap:BitmapData = new BitmapData((b.width * 2), b.height, true, 0);
            bitmap.draw(b);
            var s:Sprite = new Sprite();
            s.graphics.beginBitmapFill(bitmap, null, true, false);
            s.graphics.drawRect(0, 0, width, 1);
            s.graphics.endFill();
            s.alpha = alpha;
            s.x = x;
            return (s);
        }
        public static function getTime(t:Number=0):String{
            var _date:Date = (((t == 0)) ? new Date() : new Date(t));
            var __y:uint = _date.getFullYear();
            var __m:String = ("0" + (_date.getMonth() + 1)).substr(-2);
            var __d:String = ("0" + _date.getDate()).substr(-2);
            var _h:String = ("0" + _date.getHours()).substr(-2);
            var _m:String = ("0" + _date.getMinutes()).substr(-2);
            var _s:String = ("0" + _date.getSeconds()).substr(-2);
            return (((((((((((__y + "-") + __m) + "-") + __d) + " ") + _h) + ":") + _m) + ":") + _s));
        }
        public static function clone(source:Object):Object{
            var myBA:ByteArray = new ByteArray();
            myBA.writeObject(source);
            myBA.position = 0;
            return (myBA.readObject());
        }
        public static function del(source:Object, key:String):void{
            if (((((source) && ((typeof(source) == "object")))) && (!((typeof(source[key]) == "undefined"))))){
                delete source[key];
            };
        }
        public static function byte2string(b:ByteArray):String{
            var data:ByteArray = new ByteArray();
            data.writeBytes(b);
            data.position = 0;
            return (data.readMultiByte(data.length, "utf-8"));
        }
        public static function getBitmap(d:DisplayObject, btnWidth:Number=0, btnHeight:Number=0):BitmapData{
            if (btnWidth == 0){
                btnWidth = d.width;
            };
            if (btnHeight == 0){
                btnHeight = d.height;
            };
            var bitmap:BitmapData = new BitmapData((btnWidth + 2), btnHeight, true, 0);
            bitmap.draw(d);
            return (bitmap);
        }
        public static function _parseInt(s:String):int{
            var t:int = parseInt(s);
            if (isNaN(t)){
                t = 0;
            };
            return (t);
        }
        public static function option(key:String, def:String=""):String{
            if (typeof(Onez.info[key]) == "undefined"){
                Onez.info[key] = def;
            };
            return (Onez.info[key]);
        }
        public static function ubb(msg:String):String{
            msg = msg.replace(/@([^\s+]+)\s/g, "<u><a href=\"event:u.$1\">$1</a></u>");
            msg = msg.replace(/\[color=(#|)([0-9a-fA-F]{6})\](.+?)\[\/color\]/g, "<font color=\"#$2\">$3</font>");
            msg = msg.replace(/\[size=([0-9]{1,2})\](.+?)\[\/size\]/g, "<font size=\"$1\">$2</font>");
            msg = msg.replace(/\[u\](.+?)\[\/u\]/g, "<u>$1</u>");
            msg = msg.replace(/\[i\](.+?)\[\/i\]/g, "<i>$1</i>");
            msg = msg.replace(/(http\:\/\/[^\s\t ]+)/g, "<u><a href=\"$1\" target=\"_blank\">$1</a></u>");
            msg = msg.replace(/([^\/]{1})www\.([^\s\t ]+)/g, "<u><a href=\"$1http://www.$2\" target=\"_blank\">www.$2</a></u>");
            msg = msg.replace(/\[[a-zA-Z\/=#0-9\s]+\]/g, "");
            return (msg);
        }
        public static function twoNum(t:int):String{
            var s:String = t.toString();
            if (s.length < 2){
                s = ("0" + s);
            };
            return (s);
        }
        public static function checkTime(now:Date, start_h:int, start_i:int, end_h:int, end_i:int):Boolean{
            var t:int = ((now.getHours() * 60) + now.getMinutes());
            if ((((start_h == end_h)) && ((start_i == end_i)))){
                return (true);
            };
            if (end_h >= start_h){
                return ((((((start_h * 60) + start_i) <= t)) && ((((end_h * 60) + end_i) > t))));
            };
            return ((((((start_h * 60) + start_i) <= t)) || ((((end_h * 60) + end_i) > t))));
        }

    }
}//package com.onez.common 
﻿package com.onez.common {
    import flash.net.*;
    import flash.display.*;
    import flash.events.*;
    import flash.utils.*;

    public final class OnezLoader {

        private static var _num:int = 0;

        public static function load(url:String, complete:Function, type:String="text", postdata:Object=null):void{
            var vars:URLVariables;
            var k:String;
            var urlloader:URLLoader;
            var loader:Loader;
            var r:URLRequest = new URLRequest(url);
            if (postdata != null){
                r.method = URLRequestMethod.POST;
                vars = new URLVariables();
                for (k in postdata) {
                    vars[k] = postdata[k];
                };
                r.data = vars;
            };
            trace(url);
            if (type == "text"){
                urlloader = new URLLoader();
                urlloader.addEventListener(Event.COMPLETE, Delegate.create(onComplete, complete));
                urlloader.addEventListener(IOErrorEvent.IO_ERROR, Delegate.create(onError, complete));
                urlloader.addEventListener(SecurityErrorEvent.SECURITY_ERROR, Delegate.create(onSecurity, complete));
                urlloader.load(r);
            } else {
                loader = new Loader();
                loader.contentLoaderInfo.addEventListener(Event.COMPLETE, Delegate.create(onComplete, complete));
                loader.contentLoaderInfo.addEventListener(IOErrorEvent.IO_ERROR, Delegate.create(onError, complete));
                loader.contentLoaderInfo.addEventListener(SecurityErrorEvent.SECURITY_ERROR, Delegate.create(onSecurity, complete));
                loader.load(r);
                trace("bitmap");
            };
            num++;
        }
        private static function onComplete(e:Event, complete:Function):void{
            num--;
            OnezComplete(e, complete);
        }
        private static function onError(e:IOErrorEvent, complete:Function):void{
            num--;
            OnezComplete(e, complete);
        }
        private static function onSecurity(e:SecurityErrorEvent, complete:Function):void{
        }
        private static function get num():int{
            return (_num);
        }
        private static function set num(value:int):void{
            _num = value;
            if (_num < 0){
                _num = 0;
            };
        }
        public static function Upload(url:String, params:Object, images:Array, complete:Function=null):void{
            var value:String;
            var name:String;
            var boundary:String = makeBoundary();
            var req:URLRequest = new URLRequest(url);
            req.method = URLRequestMethod.POST;
            req.contentType = ("multipart/form-data; boundary=" + boundary);
            var postData:ByteArray = new ByteArray();
            postData.endian = Endian.BIG_ENDIAN;
            if (params){
                for (name in params) {
                    boundaryPostData(postData, boundary);
                    addLineBreak(postData);
                    postData.writeUTFBytes((("Content-Disposition: form-data; name=\"" + name) + "\""));
                    addLineBreak(postData);
                    addLineBreak(postData);
                    postData.writeUTFBytes(params[name]);
                    addLineBreak(postData);
                };
            };
            var i:int;
            while (i < images.length) {
                boundaryPostData(postData, boundary);
                addLineBreak(postData);
                postData.writeUTFBytes((((("Content-Disposition: form-data; name=\"" + images[i].field) + "\"; filename=\"") + images[i].name) + "\""));
                addLineBreak(postData);
                postData.writeUTFBytes("Content-Type: image/pjpeg");
                addLineBreak(postData);
                addLineBreak(postData);
                postData.writeBytes(images[i].data, 0, images[i].data.length);
                addLineBreak(postData);
                i++;
            };
            boundaryPostData(postData, boundary);
            addDoubleDash(postData);
            postData.position = 0;
            req.data = postData;
            var loader:URLLoader = new URLLoader();
            loader.addEventListener(IOErrorEvent.IO_ERROR, Delegate.create(OnezComplete, complete));
            loader.addEventListener(Event.COMPLETE, Delegate.create(OnezComplete, complete));
            loader.addEventListener(SecurityErrorEvent.SECURITY_ERROR, Delegate.create(OnezComplete, complete));
            loader.load(req);
            num++;
        }
        private static function OnezComplete(e:Event, complete:Function=null):void{
            var e:* = e;
            var complete = complete;
            num--;
            if (complete == null){
                return;
            };
            if ((e.currentTarget is URLLoader)){
                trace(e.currentTarget.data);
                complete(e.currentTarget.data);
            } else {
                if (e.type == Event.COMPLETE){
                    try {
                        complete(Bitmap(e.currentTarget.content).bitmapData);
                    } catch(err:SecurityError) {
                        loaderSecurity(e.currentTarget.bytes, complete);
                    };
                } else {
                    complete(null);
                };
            };
        }
        private static function loaderSecurity(bytes:ByteArray, complete:Function):void{
            var loader:Loader = new Loader();
            loader.contentLoaderInfo.addEventListener(Event.COMPLETE, Delegate.create(loaderSecurityComplete, loader, complete));
            loader.cacheAsBitmap = true;
            loader.loadBytes(bytes);
        }
        private static function loaderSecurityComplete(e:Event, loader:Loader, complete:Function):void{
            var bitmap:BitmapData = new BitmapData(loader.width, loader.height, true, 0);
            bitmap.draw(loader);
            complete(bitmap);
        }
        private static function boundaryPostData(data:ByteArray, boundary:String):void{
            var len:int = boundary.length;
            addDoubleDash(data);
            var i:int;
            while (i < len) {
                data.writeByte(boundary.charCodeAt(i));
                i++;
            };
        }
        private static function addDoubleDash(data:ByteArray):void{
            data.writeShort(0x2D2D);
        }
        private static function addLineBreak(data:ByteArray):void{
            data.writeShort(3338);
        }
        private static function makeBoundary():String{
            var boundary:String = "";
            var i:int;
            while (i < 13) {
                boundary = (boundary + String.fromCharCode(int((97 + (Math.random() * 25)))));
                i++;
            };
            boundary = ("---------------------------" + boundary);
            return (boundary);
        }

    }
}//package com.onez.common 
﻿package com.onez.common {
    import flash.utils.*;
    import flash.display.*;

    public class Delegate {

        private static var funDictionary:Dictionary = new Dictionary();

        public static function create(method:Function, ... _args):Function{
            return (createWithArgs(method, _args));
        }
        public static function createListener(method:Function, $listenerCurrentTarget:InteractiveObject, ... _args):Function{
            return (createWithArgs(method, _args, true, $listenerCurrentTarget));
        }
        private static function createWithArgs(func:Function, args, needRemove:Boolean=false, $listenerCurrentTarget:InteractiveObject=null):Function{
            var funDic:* = null;
            var func:* = func;
            var args:* = args;
            var needRemove:Boolean = needRemove;
            var $listenerCurrentTarget = $listenerCurrentTarget;
            var f:* = function (){
                var func0:Function = arguments.callee.func;
                var parameters:Array = arguments.concat(args);
                return (func0.apply(null, parameters));
            };
            f["func"] = func;
            if (needRemove){
                funDic = null;
                if (($listenerCurrentTarget in funDictionary)){
                    funDic = (funDictionary[$listenerCurrentTarget] as Dictionary);
                } else {
                    funDic = new Dictionary();
                    funDictionary[$listenerCurrentTarget] = funDic;
                };
                funDic[func] = f;
            };
            return (f);
        }

    }
}//package com.onez.common 
﻿package com.greensock {
    import flash.utils.*;
    import flash.display.*;
    import com.greensock.core.*;
    import flash.events.*;
    import com.greensock.plugins.*;

    public class TweenLite extends TweenCore {

        public static const version:Number = 11.62;

        public static var rootTimeline:SimpleTimeline;
        public static var fastEaseLookup:Dictionary = new Dictionary(false);
        public static var onPluginEvent:Function;
        public static var rootFramesTimeline:SimpleTimeline;
        public static var defaultEase:Function = TweenLite.easeOut;
        public static var plugins:Object = {};
        public static var masterList:Dictionary = new Dictionary(false);
        public static var overwriteManager:Object;
        public static var rootFrame:Number;
        public static var killDelayedCallsTo:Function = TweenLite.killTweensOf;
        private static var _shape:Shape = new Shape();
        protected static var _reservedProps:Object = {
            ease:1,
            delay:1,
            overwrite:1,
            onComplete:1,
            onCompleteParams:1,
            useFrames:1,
            runBackwards:1,
            startAt:1,
            onUpdate:1,
            onUpdateParams:1,
            onStart:1,
            onStartParams:1,
            onInit:1,
            onInitParams:1,
            onReverseComplete:1,
            onReverseCompleteParams:1,
            onRepeat:1,
            onRepeatParams:1,
            proxiedEase:1,
            easeParams:1,
            yoyo:1,
            onCompleteListener:1,
            onUpdateListener:1,
            onStartListener:1,
            onReverseCompleteListener:1,
            onRepeatListener:1,
            orientToBezier:1,
            timeScale:1,
            immediateRender:1,
            repeat:1,
            repeatDelay:1,
            timeline:1,
            data:1,
            paused:1
        };

        protected var _hasPlugins:Boolean;
        public var propTweenLookup:Object;
        public var cachedPT1:PropTween;
        protected var _overwrite:int;
        protected var _ease:Function;
        public var target:Object;
        public var ratio:Number = 0;
        protected var _overwrittenProps:Object;
        protected var _notifyPluginsOfEnabled:Boolean;

        public function TweenLite(target:Object, duration:Number, vars:Object){
            var sibling:TweenLite;
            super(duration, vars);
            if (target == null){
                throw (new Error("Cannot tween a null object."));
            };
            this.target = target;
            if ((((this.target is TweenCore)) && (this.vars.timeScale))){
                this.cachedTimeScale = 1;
            };
            propTweenLookup = {};
            _ease = defaultEase;
            _overwrite = ((((!((Number(vars.overwrite) > -1))) || (((!(overwriteManager.enabled)) && ((vars.overwrite > 1)))))) ? overwriteManager.mode : int(vars.overwrite));
            var a:Array = masterList[target];
            if (!(a)){
                masterList[target] = [this];
            } else {
                if (_overwrite == 1){
                    for each (sibling in a) {
                        if (!(sibling.gc)){
                            sibling.setEnabled(false, false);
                        };
                    };
                    masterList[target] = [this];
                } else {
                    a[a.length] = this;
                };
            };
            if (((this.active) || (this.vars.immediateRender))){
                renderTime(0, false, true);
            };
        }
        public static function initClass():void{
            rootFrame = 0;
            rootTimeline = new SimpleTimeline(null);
            rootFramesTimeline = new SimpleTimeline(null);
            rootTimeline.cachedStartTime = (getTimer() * 0.001);
            rootFramesTimeline.cachedStartTime = rootFrame;
            rootTimeline.autoRemoveChildren = true;
            rootFramesTimeline.autoRemoveChildren = true;
            _shape.addEventListener(Event.ENTER_FRAME, updateAll, false, 0, true);
            if (overwriteManager == null){
                overwriteManager = {
                    mode:1,
                    enabled:false
                };
            };
        }
        public static function killTweensOf(target:Object, complete:Boolean=false, vars:Object=null):void{
            var a:Array;
            var i:int;
            var tween:TweenLite;
            if ((target in masterList)){
                a = masterList[target];
                i = a.length;
                while (--i > -1) {
                    tween = a[i];
                    if (!(tween.gc)){
                        if (complete){
                            tween.complete(false, false);
                        };
                        if (vars != null){
                            tween.killVars(vars);
                        };
                        if ((((vars == null)) || ((((tween.cachedPT1 == null)) && (tween.initted))))){
                            tween.setEnabled(false, false);
                        };
                    };
                };
                if (vars == null){
                    delete masterList[target];
                };
            };
        }
        public static function from(target:Object, duration:Number, vars:Object):TweenLite{
            vars.runBackwards = true;
            if (!(("immediateRender" in vars))){
                vars.immediateRender = true;
            };
            return (new TweenLite(target, duration, vars));
        }
        protected static function easeOut(t:Number, b:Number, c:Number, d:Number):Number{
            t = (1 - (t / d));
            return ((1 - (t * t)));
        }
        public static function delayedCall(delay:Number, onComplete:Function, onCompleteParams:Array=null, useFrames:Boolean=false):TweenLite{
            return (new TweenLite(onComplete, 0, {
                delay:delay,
                onComplete:onComplete,
                onCompleteParams:onCompleteParams,
                immediateRender:false,
                useFrames:useFrames,
                overwrite:0
            }));
        }
        protected static function updateAll(e:Event=null):void{
            var ml:Dictionary;
            var tgt:Object;
            var a:Array;
            var i:int;
            rootTimeline.renderTime((((getTimer() * 0.001) - rootTimeline.cachedStartTime) * rootTimeline.cachedTimeScale), false, false);
            rootFrame = (rootFrame + 1);
            rootFramesTimeline.renderTime(((rootFrame - rootFramesTimeline.cachedStartTime) * rootFramesTimeline.cachedTimeScale), false, false);
            if (!((rootFrame % 60))){
                ml = masterList;
                for (tgt in ml) {
                    a = ml[tgt];
                    i = a.length;
                    while (--i > -1) {
                        if (TweenLite(a[i]).gc){
                            a.splice(i, 1);
                        };
                    };
                    if (a.length == 0){
                        delete ml[tgt];
                    };
                };
            };
        }
        public static function to(target:Object, duration:Number, vars:Object):TweenLite{
            return (new TweenLite(target, duration, vars));
        }

        protected function easeProxy(t:Number, b:Number, c:Number, d:Number):Number{
            return (this.vars.proxiedEase.apply(null, arguments.concat(this.vars.easeParams)));
        }
        override public function renderTime(time:Number, suppressEvents:Boolean=false, force:Boolean=false):void{
            var isComplete:Boolean;
            var prevTime:Number = this.cachedTime;
            if (time >= this.cachedDuration){
                this.cachedTotalTime = (this.cachedTime = this.cachedDuration);
                this.ratio = 1;
                isComplete = true;
                if (this.cachedDuration == 0){
                    if ((((((time == 0)) || ((_rawPrevTime < 0)))) && (!((_rawPrevTime == time))))){
                        force = true;
                    };
                    _rawPrevTime = time;
                };
            } else {
                if (time <= 0){
                    this.cachedTotalTime = (this.cachedTime = (this.ratio = 0));
                    if (time < 0){
                        this.active = false;
                        if (this.cachedDuration == 0){
                            if (_rawPrevTime >= 0){
                                force = true;
                                isComplete = true;
                            };
                            _rawPrevTime = time;
                        };
                    };
                    if (((this.cachedReversed) && (!((prevTime == 0))))){
                        isComplete = true;
                    };
                } else {
                    this.cachedTotalTime = (this.cachedTime = time);
                    this.ratio = _ease(time, 0, 1, this.cachedDuration);
                };
            };
            if ((((this.cachedTime == prevTime)) && (!(force)))){
                return;
            };
            if (!(this.initted)){
                init();
                if (((!(isComplete)) && (this.cachedTime))){
                    this.ratio = _ease(this.cachedTime, 0, 1, this.cachedDuration);
                };
            };
            if (((!(this.active)) && (!(this.cachedPaused)))){
                this.active = true;
            };
            if ((((((((prevTime == 0)) && (this.vars.onStart))) && (((!((this.cachedTime == 0))) || ((this.cachedDuration == 0)))))) && (!(suppressEvents)))){
                this.vars.onStart.apply(null, this.vars.onStartParams);
            };
            var pt:PropTween = this.cachedPT1;
            while (pt) {
                pt.target[pt.property] = (pt.start + (this.ratio * pt.change));
                pt = pt.nextNode;
            };
            if (((_hasUpdate) && (!(suppressEvents)))){
                this.vars.onUpdate.apply(null, this.vars.onUpdateParams);
            };
            if (((isComplete) && (!(this.gc)))){
                if (((_hasPlugins) && (this.cachedPT1))){
                    onPluginEvent("onComplete", this);
                };
                complete(true, suppressEvents);
            };
        }
        override public function setEnabled(enabled:Boolean, ignoreTimeline:Boolean=false):Boolean{
            var a:Array;
            if (enabled){
                a = TweenLite.masterList[this.target];
                if (!(a)){
                    TweenLite.masterList[this.target] = [this];
                } else {
                    a[a.length] = this;
                };
            };
            super.setEnabled(enabled, ignoreTimeline);
            if (((_notifyPluginsOfEnabled) && (this.cachedPT1))){
                return (onPluginEvent(((enabled) ? "onEnable" : "onDisable"), this));
            };
            return (false);
        }
        protected function init():void{
            var p:String;
            var i:int;
            var plugin:*;
            var prioritize:Boolean;
            var siblings:Array;
            var pt:PropTween;
            if (this.vars.onInit){
                this.vars.onInit.apply(null, this.vars.onInitParams);
            };
            if (typeof(this.vars.ease) == "function"){
                _ease = this.vars.ease;
            };
            if (this.vars.easeParams){
                this.vars.proxiedEase = _ease;
                _ease = easeProxy;
            };
            this.cachedPT1 = null;
            this.propTweenLookup = {};
            for (p in this.vars) {
                if ((((p in _reservedProps)) && (!((((p == "timeScale")) && ((this.target is TweenCore))))))){
                } else {
                    if ((((p in plugins)) && ((plugin = new ((plugins[p] as Class))()).onInitTween(this.target, this.vars[p], this)))){
                        this.cachedPT1 = new PropTween(plugin, "changeFactor", 0, 1, ((plugin.overwriteProps.length)==1) ? plugin.overwriteProps[0] : "_MULTIPLE_", true, this.cachedPT1);
                        if (this.cachedPT1.name == "_MULTIPLE_"){
                            i = plugin.overwriteProps.length;
                            while (--i > -1) {
                                this.propTweenLookup[plugin.overwriteProps[i]] = this.cachedPT1;
                            };
                        } else {
                            this.propTweenLookup[this.cachedPT1.name] = this.cachedPT1;
                        };
                        if (plugin.priority){
                            this.cachedPT1.priority = plugin.priority;
                            prioritize = true;
                        };
                        if (((plugin.onDisable) || (plugin.onEnable))){
                            _notifyPluginsOfEnabled = true;
                        };
                        _hasPlugins = true;
                    } else {
                        this.cachedPT1 = new PropTween(this.target, p, Number(this.target[p]), ((typeof(this.vars[p]))=="number") ? (Number(this.vars[p]) - this.target[p]) : Number(this.vars[p]), p, false, this.cachedPT1);
                        this.propTweenLookup[p] = this.cachedPT1;
                    };
                };
            };
            if (prioritize){
                onPluginEvent("onInitAllProps", this);
            };
            if (this.vars.runBackwards){
                pt = this.cachedPT1;
                while (pt) {
                    pt.start = (pt.start + pt.change);
                    pt.change = -(pt.change);
                    pt = pt.nextNode;
                };
            };
            _hasUpdate = Boolean(!((this.vars.onUpdate == null)));
            if (_overwrittenProps){
                killVars(_overwrittenProps);
                if (this.cachedPT1 == null){
                    this.setEnabled(false, false);
                };
            };
            if ((((((((_overwrite > 1)) && (this.cachedPT1))) && ((siblings = masterList[this.target])))) && ((siblings.length > 1)))){
                if (overwriteManager.manageOverwrites(this, this.propTweenLookup, siblings, _overwrite)){
                    init();
                };
            };
            this.initted = true;
        }
        public function killVars(vars:Object, permanent:Boolean=true):Boolean{
            var p:String;
            var pt:PropTween;
            var changed:Boolean;
            if (_overwrittenProps == null){
                _overwrittenProps = {};
            };
            for (p in vars) {
                if ((p in propTweenLookup)){
                    pt = propTweenLookup[p];
                    if (((pt.isPlugin) && ((pt.name == "_MULTIPLE_")))){
                        pt.target.killProps(vars);
                        if (pt.target.overwriteProps.length == 0){
                            pt.name = "";
                        };
                        if (((!((p == pt.target.propName))) || ((pt.name == "")))){
                            delete propTweenLookup[p];
                        };
                    };
                    if (pt.name != "_MULTIPLE_"){
                        if (pt.nextNode){
                            pt.nextNode.prevNode = pt.prevNode;
                        };
                        if (pt.prevNode){
                            pt.prevNode.nextNode = pt.nextNode;
                        } else {
                            if (this.cachedPT1 == pt){
                                this.cachedPT1 = pt.nextNode;
                            };
                        };
                        if (((pt.isPlugin) && (pt.target.onDisable))){
                            pt.target.onDisable();
                            if (pt.target.activeDisable){
                                changed = true;
                            };
                        };
                        delete propTweenLookup[p];
                    };
                };
                if (((permanent) && (!((vars == _overwrittenProps))))){
                    _overwrittenProps[p] = 1;
                };
            };
            return (changed);
        }
        override public function invalidate():void{
            if (((_notifyPluginsOfEnabled) && (this.cachedPT1))){
                onPluginEvent("onDisable", this);
            };
            this.cachedPT1 = null;
            _overwrittenProps = null;
            _hasUpdate = (this.initted = (this.active = (_notifyPluginsOfEnabled = false)));
            this.propTweenLookup = {};
        }

    }
}//package com.greensock 
﻿package com.greensock.core {
    import com.greensock.*;

    public class TweenCore {

        public static const version:Number = 1.62;

        protected static var _classInitted:Boolean;

        public var initted:Boolean;
        protected var _hasUpdate:Boolean;
        public var active:Boolean;
        protected var _delay:Number;
        public var cachedReversed:Boolean;
        public var nextNode:TweenCore;
        public var cachedTime:Number;
        protected var _rawPrevTime:Number = -1;
        public var vars:Object;
        public var cachedTotalTime:Number;
        public var data;
        public var timeline:SimpleTimeline;
        public var cachedOrphan:Boolean;
        public var cachedStartTime:Number;
        public var prevNode:TweenCore;
        public var cachedDuration:Number;
        public var gc:Boolean;
        public var cachedPauseTime:Number;
        public var cacheIsDirty:Boolean;
        public var cachedPaused:Boolean;
        public var cachedTimeScale:Number;
        public var cachedTotalDuration:Number;

        public function TweenCore(duration:Number=0, vars:Object=null){
            super();
            this.vars = ((vars)!=null) ? vars : {};
            if (this.vars.isGSVars){
                this.vars = this.vars.vars;
            };
            this.cachedDuration = (this.cachedTotalDuration = duration);
            _delay = ((this.vars.delay) ? Number(this.vars.delay) : 0);
            this.cachedTimeScale = ((this.vars.timeScale) ? Number(this.vars.timeScale) : 1);
            this.active = Boolean((((((duration == 0)) && ((_delay == 0)))) && (!((this.vars.immediateRender == false)))));
            this.cachedTotalTime = (this.cachedTime = 0);
            this.data = this.vars.data;
            if (!(_classInitted)){
                if (isNaN(TweenLite.rootFrame)){
                    TweenLite.initClass();
                    _classInitted = true;
                } else {
                    return;
                };
            };
            var tl:SimpleTimeline = (((this.vars.timeline is SimpleTimeline)) ? this.vars.timeline : ((this.vars.useFrames) ? TweenLite.rootFramesTimeline : TweenLite.rootTimeline));
            tl.insert(this, tl.cachedTotalTime);
            if (this.vars.reversed){
                this.cachedReversed = true;
            };
            if (this.vars.paused){
                this.paused = true;
            };
        }
        public function renderTime(time:Number, suppressEvents:Boolean=false, force:Boolean=false):void{
        }
        public function get delay():Number{
            return (_delay);
        }
        public function get duration():Number{
            return (this.cachedDuration);
        }
        public function set reversed(b:Boolean):void{
            if (b != this.cachedReversed){
                this.cachedReversed = b;
                setTotalTime(this.cachedTotalTime, true);
            };
        }
        public function set startTime(n:Number):void{
            if (((!((this.timeline == null))) && (((!((n == this.cachedStartTime))) || (this.gc))))){
                this.timeline.insert(this, (n - _delay));
            } else {
                this.cachedStartTime = n;
            };
        }
        public function restart(includeDelay:Boolean=false, suppressEvents:Boolean=true):void{
            this.reversed = false;
            this.paused = false;
            this.setTotalTime(((includeDelay) ? -(_delay) : 0), suppressEvents);
        }
        public function set delay(n:Number):void{
            this.startTime = (this.startTime + (n - _delay));
            _delay = n;
        }
        public function resume():void{
            this.paused = false;
        }
        public function get paused():Boolean{
            return (this.cachedPaused);
        }
        public function play():void{
            this.reversed = false;
            this.paused = false;
        }
        public function set duration(n:Number):void{
            var ratio:Number = (n / this.cachedDuration);
            this.cachedDuration = (this.cachedTotalDuration = n);
            if (((((this.active) && (!(this.cachedPaused)))) && (!((n == 0))))){
                this.setTotalTime((this.cachedTotalTime * ratio), true);
            };
            setDirtyCache(false);
        }
        public function invalidate():void{
        }
        public function complete(skipRender:Boolean=false, suppressEvents:Boolean=false):void{
            if (!(skipRender)){
                renderTime(this.totalDuration, suppressEvents, false);
                return;
            };
            if (this.timeline.autoRemoveChildren){
                this.setEnabled(false, false);
            } else {
                this.active = false;
            };
            if (!(suppressEvents)){
                if (((((this.vars.onComplete) && ((this.cachedTotalTime >= this.cachedTotalDuration)))) && (!(this.cachedReversed)))){
                    this.vars.onComplete.apply(null, this.vars.onCompleteParams);
                } else {
                    if (((((this.cachedReversed) && ((this.cachedTotalTime == 0)))) && (this.vars.onReverseComplete))){
                        this.vars.onReverseComplete.apply(null, this.vars.onReverseCompleteParams);
                    };
                };
            };
        }
        public function get totalTime():Number{
            return (this.cachedTotalTime);
        }
        public function get startTime():Number{
            return (this.cachedStartTime);
        }
        public function get reversed():Boolean{
            return (this.cachedReversed);
        }
        public function set currentTime(n:Number):void{
            setTotalTime(n, false);
        }
        protected function setDirtyCache(includeSelf:Boolean=true):void{
            var tween:TweenCore = ((includeSelf) ? this : this.timeline);
            while (tween) {
                tween.cacheIsDirty = true;
                tween = tween.timeline;
            };
        }
        public function reverse(forceResume:Boolean=true):void{
            this.reversed = true;
            if (forceResume){
                this.paused = false;
            } else {
                if (this.gc){
                    this.setEnabled(true, false);
                };
            };
        }
        public function set paused(b:Boolean):void{
            if (((!((b == this.cachedPaused))) && (this.timeline))){
                if (b){
                    this.cachedPauseTime = this.timeline.rawTime;
                } else {
                    this.cachedStartTime = (this.cachedStartTime + (this.timeline.rawTime - this.cachedPauseTime));
                    this.cachedPauseTime = NaN;
                    setDirtyCache(false);
                };
                this.cachedPaused = b;
                this.active = Boolean(((((!(this.cachedPaused)) && ((this.cachedTotalTime > 0)))) && ((this.cachedTotalTime < this.cachedTotalDuration))));
            };
            if (((!(b)) && (this.gc))){
                this.setTotalTime(this.cachedTotalTime, false);
                this.setEnabled(true, false);
            };
        }
        public function kill():void{
            setEnabled(false, false);
        }
        public function set totalTime(n:Number):void{
            setTotalTime(n, false);
        }
        public function get currentTime():Number{
            return (this.cachedTime);
        }
        protected function setTotalTime(time:Number, suppressEvents:Boolean=false):void{
            var tlTime:Number;
            var dur:Number;
            if (this.timeline){
                tlTime = ((((this.cachedPauseTime) || ((this.cachedPauseTime == 0)))) ? this.cachedPauseTime : this.timeline.cachedTotalTime);
                if (this.cachedReversed){
                    dur = ((this.cacheIsDirty) ? this.totalDuration : this.cachedTotalDuration);
                    this.cachedStartTime = (tlTime - ((dur - time) / this.cachedTimeScale));
                } else {
                    this.cachedStartTime = (tlTime - (time / this.cachedTimeScale));
                };
                if (!(this.timeline.cacheIsDirty)){
                    setDirtyCache(false);
                };
                if (this.cachedTotalTime != time){
                    renderTime(time, suppressEvents, false);
                };
            };
        }
        public function pause():void{
            this.paused = true;
        }
        public function set totalDuration(n:Number):void{
            this.duration = n;
        }
        public function get totalDuration():Number{
            return (this.cachedTotalDuration);
        }
        public function setEnabled(enabled:Boolean, ignoreTimeline:Boolean=false):Boolean{
            this.gc = !(enabled);
            if (enabled){
                this.active = Boolean(((((!(this.cachedPaused)) && ((this.cachedTotalTime > 0)))) && ((this.cachedTotalTime < this.cachedTotalDuration))));
                if (((!(ignoreTimeline)) && (this.cachedOrphan))){
                    this.timeline.insert(this, (this.cachedStartTime - _delay));
                };
            } else {
                this.active = false;
                if (((!(ignoreTimeline)) && (!(this.cachedOrphan)))){
                    this.timeline.remove(this, true);
                };
            };
            return (false);
        }

    }
}//package com.greensock.core 
﻿package com.greensock.core {

    public class SimpleTimeline extends TweenCore {

        public var autoRemoveChildren:Boolean;
        protected var _lastChild:TweenCore;
        protected var _firstChild:TweenCore;

        public function SimpleTimeline(vars:Object=null){
            super(0, vars);
        }
        public function get rawTime():Number{
            return (this.cachedTotalTime);
        }
        public function insert(tween:TweenCore, time=0):TweenCore{
            if (((!(tween.cachedOrphan)) && (tween.timeline))){
                tween.timeline.remove(tween, true);
            };
            tween.timeline = this;
            tween.cachedStartTime = (Number(time) + tween.delay);
            if (tween.gc){
                tween.setEnabled(true, true);
            };
            if (_lastChild){
                _lastChild.nextNode = tween;
            } else {
                _firstChild = tween;
            };
            tween.prevNode = _lastChild;
            _lastChild = tween;
            tween.nextNode = null;
            tween.cachedOrphan = false;
            return (tween);
        }
        override public function renderTime(time:Number, suppressEvents:Boolean=false, force:Boolean=false):void{
            var dur:Number;
            var next:TweenCore;
            var tween:TweenCore = _firstChild;
            this.cachedTotalTime = time;
            this.cachedTime = time;
            while (tween) {
                next = tween.nextNode;
                if (((tween.active) || ((((((time >= tween.cachedStartTime)) && (!(tween.cachedPaused)))) && (!(tween.gc)))))){
                    if (!(tween.cachedReversed)){
                        tween.renderTime(((time - tween.cachedStartTime) * tween.cachedTimeScale), suppressEvents, false);
                    } else {
                        dur = ((tween.cacheIsDirty) ? tween.totalDuration : tween.cachedTotalDuration);
                        tween.renderTime((dur - ((time - tween.cachedStartTime) * tween.cachedTimeScale)), suppressEvents, false);
                    };
                };
                tween = next;
            };
        }
        public function remove(tween:TweenCore, skipDisable:Boolean=false):void{
            if (tween.cachedOrphan){
                return;
            };
            if (!(skipDisable)){
                tween.setEnabled(false, true);
            };
            if (tween.nextNode){
                tween.nextNode.prevNode = tween.prevNode;
            } else {
                if (_lastChild == tween){
                    _lastChild = tween.prevNode;
                };
            };
            if (tween.prevNode){
                tween.prevNode.nextNode = tween.nextNode;
            } else {
                if (_firstChild == tween){
                    _firstChild = tween.nextNode;
                };
            };
            tween.cachedOrphan = true;
        }

    }
}//package com.greensock.core 
﻿package com.greensock.core {

    public final class PropTween {

        public var priority:int;
        public var start:Number;
        public var prevNode:PropTween;
        public var change:Number;
        public var target:Object;
        public var name:String;
        public var property:String;
        public var nextNode:PropTween;
        public var isPlugin:Boolean;

        public function PropTween(target:Object, property:String, start:Number, change:Number, name:String, isPlugin:Boolean, nextNode:PropTween=null, priority:int=0){
            super();
            this.target = target;
            this.property = property;
            this.start = start;
            this.change = change;
            this.name = name;
            this.isPlugin = isPlugin;
            if (nextNode){
                nextNode.prevNode = this;
                this.nextNode = nextNode;
            };
            this.priority = priority;
        }
    }
}//package com.greensock.core 
﻿package {
    import mx.core.*;

    public class Main_img001 extends BitmapAsset {

    }
}//package