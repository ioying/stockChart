package {
    import flash.events.*;
    import flash.display.*;
    import com.onez.common.*;
    import flash.system.*;
    import flash.net.*;
    import flash.external.*;

    public class Main extends Sprite {

        private var pic:Class;
        private var btn:Sprite;
        private var d:DisplayObject;
        private var maskbox:Sprite;
        private var file:FileReference;
        private var status:String = "";

        public function Main():void{
            this.pic = Main_pic;
            super();
            if (stage){
                this.init();
            } else {
                addEventListener(Event.ADDED_TO_STAGE, this.init);
            };
        }
        private function init(e:Event=null):void{
            removeEventListener(Event.ADDED_TO_STAGE, this.init);
            stage.align = StageAlign.TOP_LEFT;
            stage.scaleMode = StageScaleMode.NO_SCALE;
            Onez.init(stage, this);
            Security.allowDomain("*");
            Security.allowInsecureDomain("*");
            Onez.info.siteurl = Onez.option("url");
            Onez.info.method = Onez.option("method", "OnezUploadCall");
            this.d = new this.pic();
            this.btn = new Sprite();
            this.btn.addChild(this.d);
            this.btn.buttonMode = true;
            addChild(this.btn);
            this.btn.addEventListener(MouseEvent.MOUSE_DOWN, this.btnHandler);
            this.btn.addEventListener(MouseEvent.MOUSE_OVER, this.btnHandler);
            this.btn.addEventListener(MouseEvent.MOUSE_OUT, this.btnHandler);
            this.btn.addEventListener(MouseEvent.CLICK, this.btnHandler);
            this.maskbox = new Sprite();
            this.maskbox.mouseEnabled = false;
            addChild(this.maskbox);
            this.file = new FileReference();
            this.file.addEventListener(Event.SELECT, this.onSelect);
            this.file.addEventListener(DataEvent.UPLOAD_COMPLETE_DATA, this.onData);
            this.file.addEventListener(IOErrorEvent.IO_ERROR, this.onError);
            this.file.addEventListener(ProgressEvent.PROGRESS, this.onProgress);
            this.file.addEventListener(Event.CANCEL, this.onCancel);
            this.file.addEventListener(Event.COMPLETE, this.onComplete);
        }
        private function set jindu(t:Number):void{
            this.maskbox.graphics.clear();
            if ((((t <= 0)) || ((t >= 1)))){
                return;
            };
            this.maskbox.graphics.beginFill(0xFFFF00, 0.3);
            this.maskbox.graphics.drawRect(0, 0, (stage.stageWidth * t), 20);
            this.maskbox.graphics.endFill();
        }
        private function onSelect(e:Event):void{
            this.jindu = 0;
            this.file.upload(new URLRequest(((Onez.option("url") + "&t=") + Math.random())));
        }
        private function onCancel(e:Event):void{
            this.jindu = 0;
        }
        private function onComplete(e:Event):void{
            if (this.status != ""){
                if (ExternalInterface.available){
                    this.jindu = 1;
                    ExternalInterface.call(Onez.option("method"), this.status);
                };
            };
        }
        private function onData(e:DataEvent):void{
            if (ExternalInterface.available){
                this.jindu = 1;
                ExternalInterface.call(Onez.option("method"), e.data);
            };
            this.status = e.data;
        }
        private function onError(e:IOErrorEvent):void{
            if (ExternalInterface.available){
                ExternalInterface.call(Onez.option("method"), e.text);
            };
            this.jindu = 0;
        }
        private function onProgress(e:ProgressEvent):void{
            this.jindu = (e.bytesLoaded / e.bytesTotal);
        }
        private function btnHandler(e:MouseEvent):void{
            var _local2:Array;
            switch (e.type){
                case MouseEvent.MOUSE_OVER:
                    this.d.y = -20;
                    break;
                case MouseEvent.MOUSE_OUT:
                    this.d.y = 0;
                    break;
                case MouseEvent.MOUSE_DOWN:
                    this.d.y = -40;
                    break;
                case MouseEvent.CLICK:
                    _local2 = [];
                    _local2.push(new FileFilter("图片文件(*.jpg;*.gif;*.png;*.jpeg)", "*.jpg;*.gif;*.png;*.jpeg"));
                    this.file.browse(_local2);
                    break;
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

    public class Main_pic extends BitmapAsset {

    }
}//package 
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