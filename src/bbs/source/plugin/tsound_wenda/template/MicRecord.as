package fr.kikko.lab {
    import flash.utils.*;
    import flash.events.*;
    import cmodule.shine.*;
    import flash.net.*;

    public class ShineMP3Encoder extends EventDispatcher {

        public var wavData:ByteArray;
        public var mp3Data:ByteArray;
        private var cshine:Object;
        private var timer:Timer;
        private var initTime:uint;

        public function ShineMP3Encoder(wavData:ByteArray){
            super();
            this.wavData = wavData;
        }
        public function start():void{
            this.initTime = getTimer();
            this.mp3Data = new ByteArray();
            this.timer = new Timer((1000 / 30));
            this.timer.addEventListener(TimerEvent.TIMER, this.update);
            this.cshine = new CLibInit().init();
            this.cshine.init(this, this.wavData, this.mp3Data);
            if (this.timer){
                this.timer.start();
            };
        }
        public function shineError(message:String):void{
            this.timer.stop();
            this.timer.removeEventListener(TimerEvent.TIMER, this.update);
            this.timer = null;
            dispatchEvent(new ErrorEvent(ErrorEvent.ERROR, false, false, message));
        }
        public function saveAs(filename:String=".mp3"):void{
            new FileReference().save(this.mp3Data, filename);
        }
        private function update(event:TimerEvent):void{
            var percent:int = this.cshine.update();
            dispatchEvent(new ProgressEvent(ProgressEvent.PROGRESS, false, false, percent, 100));
            trace("encoding mp3...", (percent + "%"));
            if (percent == 100){
                trace("Done in", (((getTimer() - this.initTime) * 0.001) + "s"));
                this.timer.stop();
                this.timer.removeEventListener(TimerEvent.TIMER, this.update);
                this.timer = null;
                dispatchEvent(new Event(Event.COMPLETE));
            };
        }

    }
}//package fr.kikko.lab 
﻿package {
    import flash.events.*;
    import flash.display.*;
    import com.onez.common.*;
    import org.bytearray.micrecorder.encoder.*;
    import org.bytearray.micrecorder.*;
    import org.bytearray.micrecorder.events.*;
    import flash.utils.*;
    import flash.external.*;
    import fr.kikko.lab.*;
    import com.mp3.*;
    import com.greensock.*;
    import flash.net.*;
    import flash.system.*;
    import flash.media.*;

    public class Main extends Sprite {

        private const STATUS_READY:String = "ready";
        private const STATUS_PAUSE:String = "pause";
        private const STATUS_STOP:String = "stop";
        private const STATUS_RECORDING:String = "recording";

        private var status:String = "ready";
        private var buttons:Object;
        private var labels:Object;
        private var mic:Microphone;
        private var dp:Shape;
        private var dpbg:DisplayObject;
        private var dpBox:Sprite;
        private var recorder:MicRecorder;
        private var soundData:ByteArray;
        private var mp3Data:ByteArray;
        private var wavEncoder:WaveEncoder;
        private var parse:MP3Parser;
        private var wav:Sound;
        private var soundC:SoundChannel;
        private var file:FileReference;
        private var timer:Timer;
        private var item:Object;
        private var mp3Encoder:ShineMP3Encoder;
        private var maxSec:int = 0;
        private var progress:Progress;
        private var actObj:Object;
        private var sec:Number = 0;
        private var trueRecord:Boolean = false;
        private var starttime:Number = 0;

        public function Main():void{
            this.buttons = {};
            this.labels = {};
            this.item = {};
            this.actObj = {scale:0};
            super();
            if (stage){
                this.init();
            } else {
                addEventListener(Event.ADDED_TO_STAGE, this.init);
            };
        }
        private function init(e:Event=null):void{
            var e = e;
            removeEventListener(Event.ADDED_TO_STAGE, this.init);
            Onez.init(stage, this);
            Onez.info.siteurl = this.stage.loaderInfo.loaderURL.split("/source/plugin/")[0];
            stage.scaleMode = StageScaleMode.NO_SCALE;
            stage.align = StageAlign.TOP_LEFT;
            addChild(new LoadPane("images/background.png"));
            this.item.logo = new LoadPane("images/LOGO.png");
            this.item.logo.x = 32;
            this.item.logo.y = 171;
            addChild(this.item.logo);
            this.buttons.setting = new Button("setting", Delegate.create(this.__click, "setting"));
            this.buttons.setting.x = 354;
            this.buttons.setting.y = 177;
            addChild(this.buttons.setting);
            this.item.title_a = new Label("已经录制:");
            this.item.title_a.x = 65;
            this.item.title_a.y = 50;
            addChild(this.item.title_a);
            this.item.title_b = new Label("语音文件信息:");
            this.item.title_b.x = 331;
            this.item.title_b.y = 52;
            addChild(this.item.title_b);
            this.item.time = new Label("时间: 0S", 0x999999);
            this.item.time.x = 331;
            this.item.time.y = 73;
            addChild(this.item.time);
            this.item.size = new Label("大小: 0KB", 0x999999);
            this.item.size.x = 331;
            this.item.size.y = 93;
            addChild(this.item.size);
            this.item.sec = new Label("00:00:00", null, 48);
            this.item.sec.x = 60;
            this.item.sec.y = 65;
            this.item.sec.cacheAsBitmap = true;
            addChild(this.item.sec);
            this.item.tip = new Label("", null, 12);
            this.item.tip.x = 180;
            this.item.tip.y = 180;
            this.item.tip.textColor = 0xCC0000;
            this.item.tip.cacheAsBitmap = true;
            addChild(this.item.tip);
            this.dpBox = new Sprite();
            this.dpbg = new LoadPane("images/dpbg.png", null, function ():void{
                dp = new Shape();
                dp.graphics.beginFill(0xFFFF00);
                dp.graphics.drawRect(0, 0, dpbg.width, dpbg.height);
                dp.graphics.endFill();
                dpbg.mask = dp;
                dpBox.addChild(dp);
                dpBox.x = 43;
                dpBox.y = 46;
                setDP(0);
            });
            this.dpBox.addChild(this.dpbg);
            addChild(this.dpBox);
            addChild((this.buttons.record = new Button("record", Delegate.create(this.__click, "record"), 0)));
            addChild((this.buttons.stop_record = new Button("stop_record", Delegate.create(this.__click, "stop"), 0)));
            this.buttons.stop_record.visible = false;
            addChild((this.buttons.pause = new Button("pause", Delegate.create(this.__click, "pause"), 1)));
            addChild((this.buttons._continue = new Button("continue", Delegate.create(this.__click, "continue"), 1)));
            this.buttons._continue.visible = false;
            this.buttons.pause.enabled = false;
            addChild((this.buttons.play = new Button("play", Delegate.create(this.__click, "play"), 2)));
            addChild((this.buttons.stop_play = new Button("stop_play", Delegate.create(this.__click, "stop_play"), 2)));
            this.buttons.stop_play.visible = false;
            this.buttons.play.enabled = false;
            addChild((this.buttons.save = new Button("save", Delegate.create(this.__click, "save"), 3)));
            this.buttons.save.enabled = false;
            addChild((this.buttons.upload = new Button("upload", Delegate.create(this.__click, "upload"), 4)));
            addChild((this.buttons.cancel_upload = new Button("cancel_upload", Delegate.create(this.__click, "cancel_upload"), 4)));
            this.buttons.cancel_upload.visible = false;
            this.buttons.upload.enabled = false;
            this.buttons.pause.enabled = false;
            this.buttons.play.enabled = false;
            this.buttons.save.enabled = false;
            this.buttons.upload.enabled = false;
            this.wavEncoder = new WaveEncoder(1);
            this.recorder = new MicRecorder(this.wavEncoder);
            this.recorder.addEventListener(RecordingEvent.RECORDING, this.onRecording);
            this.recorder.addEventListener(Event.COMPLETE, this.onRecordComplete);
            addEventListener(Event.ENTER_FRAME, this.onEnterFrame);
            this.timer = new Timer(10);
            this.timer.addEventListener(TimerEvent.TIMER, this.onTimer);
            this.progress = new Progress();
            this.progress.x = (((stage.stageWidth - this.progress.width) / 2) - 3);
            this.progress.y = 120;
            addChild(this.progress);
            this.maxSec = parseInt(Onez.option("timelength", "0"));
            if (this.maxSec > 0){
                this.item.tip.text = (("最大录音时长：" + this.maxSec) + "秒");
            };
        }
        private function onRecording(e:RecordingEvent):void{
            if ((((this.status == this.STATUS_RECORDING)) && (!(this.trueRecord)))){
                this.trueRecord = true;
                this.starttime = new Date().time;
            };
        }
        private function onRecordComplete(e:Event):void{
            if (this.status != this.STATUS_STOP){
                return;
            };
            this.soundData = this.recorder.output;
            if (ExternalInterface.available){
                ExternalInterface.call("OnezCall", "status", "tomp3");
            };
            this.progress.color = 0xFF0000;
            this.mp3Encoder = new ShineMP3Encoder(this.soundData);
            this.mp3Encoder.addEventListener(Event.COMPLETE, this.onEncodeComplete);
            this.mp3Encoder.addEventListener(ProgressEvent.PROGRESS, this.onEncodeProgress);
            this.mp3Encoder.addEventListener(ErrorEvent.ERROR, this.onEncodeError);
            this.mp3Encoder.start();
        }
        private function onEncodeProgress(e:ProgressEvent):void{
            this.progress.value = Math.floor(((e.bytesLoaded / e.bytesTotal) * 100));
        }
        private function onEncodeError(e:ErrorEvent):void{
            if (ExternalInterface.available){
                ExternalInterface.call("OnezCall", "error", e.text);
            };
        }
        private function onEncodeComplete(e:Event):void{
            if (ExternalInterface.available){
                ExternalInterface.call("OnezCall", "status", "");
            };
            this.mp3Data = this.mp3Encoder.mp3Data;
            this.item.time.text = (("时间: " + (this.sec / 100).toFixed(1)) + "S");
            var t:Number = (this.mp3Data.length / 0x0400);
            var s:String = "";
            if (t > 0x0400){
                s = ((t / 0x0400).toFixed(1) + "MB");
            } else {
                s = (t.toFixed(1) + "KB");
            };
            this.item.size.text = ("大小: " + s);
            this.parse = new MP3Parser();
            this.parse.loadFile(this.mp3Data);
            this.parse.addEventListener(Event.COMPLETE, this.mp3Loaded);
        }
        private function setDP(scale:Number):void{
            if ((((scale < 0)) || ((scale > 1)))){
                scale = 0;
            };
            this.dp.y = (((1 - scale) * this.dpbg.height) - (((scale == 0)) ? 1 : 0));
        }
        private function onEnterFrame(e:Event):void{
            var e:* = e;
            if (this.buttons.stop_play.visible){
                try {
                    trace(this.soundC.position, this.wav.length);
                    this.progress.value = Math.floor(((this.soundC.position / this.wav.length) * 100));
                } catch(e:Error) {
                    __click("stop_play");
                };
            };
            if (this.recorder.microphone == null){
                return;
            };
            TweenLite.to(this.actObj, 0.1, {
                scale:(this.recorder.microphone.activityLevel / 100),
                onUpdate:this.__actUpdate
            });
        }
        private function __actUpdate():void{
            this.setDP(this.actObj.scale);
        }
        private function onTimer(e:TimerEvent):void{
            if (!(this.trueRecord)){
                return;
            };
            this.sec = (this.sec + ((new Date().time - this.starttime) / 10));
            if ((((this.maxSec > 0)) && ((this.sec >= (this.maxSec * 100))))){
                this.__click("stop");
            };
            this.starttime = new Date().time;
            this.item.sec.text = this.time_format(this.sec);
        }
        private function number_format(t:int, len:int=2):String{
            return (("0000" + t).substr(-(len)));
        }
        private function time_format(sec:int):String{
            var t:int = sec;
            var s:String = "";
            s = ((":" + this.number_format((t % 100))) + s);
            t = Math.floor((t / 100));
            s = ((":" + this.number_format((t % 60))) + s);
            t = Math.floor((t / 60));
            s = (this.number_format((t % 60)) + s);
            return (s);
        }
        private function __click(token:String):void{
            var token:* = token;
            switch (token){
                case "record":
                    this.buttons.record.visible = false;
                    this.buttons.stop_record.visible = true;
                    this.status = this.STATUS_RECORDING;
                    this.recorder.record();
                    this.soundData = null;
                    this.mp3Data = null;
                    this.sec = 0;
                    this.item.time.text = "时间: 0S";
                    this.item.size.text = "大小: 0KB";
                    this.buttons.pause.enabled = true;
                    this.buttons.play.enabled = false;
                    this.buttons.save.enabled = false;
                    this.buttons.upload.enabled = false;
                    this.starttime = new Date().time;
                    this.timer.start();
                    this.trueRecord = false;
                    break;
                case "pause":
                    if (this.status != this.STATUS_RECORDING){
                        if (ExternalInterface.available){
                            ExternalInterface.call("OnezCall", "error", "not recording");
                        };
                        return;
                    };
                    this.buttons._continue.visible = true;
                    this.buttons.pause.visible = false;
                    this.status = this.STATUS_PAUSE;
                    this.timer.stop();
                    this.recorder.pause(true);
                    break;
                case "continue":
                    try {
                        this.soundC.stop();
                        this.progress.value = 0;
                    } catch(e:Error) {
                    };
                    this.buttons._continue.visible = false;
                    this.buttons.pause.visible = true;
                    this.status = this.STATUS_RECORDING;
                    this.starttime = new Date().time;
                    this.timer.start();
                    this.recorder.pause(false);
                    break;
                case "stop":
                    this.buttons.pause.enabled = false;
                    this.buttons.pause.visible = true;
                    this.buttons._continue.visible = false;
                    this.buttons.play.enabled = false;
                    this.buttons.record.visible = true;
                    this.buttons.stop_record.visible = false;
                    this.status = this.STATUS_STOP;
                    this.timer.stop();
                    if (this.trueRecord){
                        this.recorder.stop();
                    };
                    break;
                case "play":
                    if ((((((((this.status == this.STATUS_RECORDING)) || ((this.status == this.STATUS_READY)))) || ((this.soundData == null)))) || ((this.soundData.length < 1)))){
                        if (ExternalInterface.available){
                            ExternalInterface.call("OnezCall", "error", "recording");
                        };
                        return;
                    };
                    try {
                        this.soundC.stop();
                        this.progress.value = 0;
                    } catch(e:Error) {
                    };
                    this.progress.color = 39219;
                    this.buttons.play.visible = false;
                    this.buttons.stop_play.visible = true;
                    this.wav = this.parse.getSound();
                    this.soundC = this.wav.play();
                    this.soundC.removeEventListener(Event.SOUND_COMPLETE, this.playComplete);
                    this.soundC.addEventListener(Event.SOUND_COMPLETE, this.playComplete);
                    break;
                case "stop_play":
                    try {
                        this.soundC.stop();
                        this.progress.value = 0;
                    } catch(e:Error) {
                    };
                    this.buttons.play.visible = true;
                    this.buttons.stop_play.visible = false;
                    break;
                case "save":
                    if (((((!((this.status == this.STATUS_STOP))) || ((this.mp3Data == null)))) || ((this.mp3Data.length < 1)))){
                        if (ExternalInterface.available){
                            ExternalInterface.call("OnezCall", "error", "no mp3data");
                        };
                        return;
                    };
                    this.file = new FileReference();
                    this.file.save(this.mp3Data, "micRecord.mp3");
                    break;
                case "upload":
                    if (((((!((this.status == this.STATUS_STOP))) || ((this.mp3Data == null)))) || ((this.mp3Data.length < 1)))){
                        if (ExternalInterface.available){
                            ExternalInterface.call("OnezCall", "error", "no mp3data");
                        };
                        return;
                    };
                    if (ExternalInterface.available){
                        ExternalInterface.call("OnezCall", "status", "uploading");
                    };
                    this.item.tip.text = "录音正在上传...";
                    this.buttons.upload.visible = false;
                    this.buttons.cancel_upload.visible = true;
                    if (Onez.option("cloud") == "1"){
                        OnezLoader.Upload(((("http://2cscs.onez.cn/onez.php?action=upload&siteurl=" + Onez.info.siteurl) + "&t=") + Math.random()), {
                            size:this.mp3Data.length,
                            sec:this.sec
                        }, [{
                            field:"data",
                            name:"microphone record.mp3",
                            data:this.mp3Data,
                            rid:Onez.option("rid", "0")
                        }], this.uploadComplete2);
                    } else {
                        OnezLoader.Upload(((Onez.info.siteurl + "/plugin.php?id=tsound_wenda&action=upload&t=") + Math.random()), {
                            size:this.mp3Data.length,
                            sec:this.sec,
                            rid:Onez.option("rid", "0")
                        }, [{
                            field:"data",
                            name:"microphone record.mp3",
                            data:this.mp3Data
                        }], this.uploadComplete);
                    };
                    break;
                case "cancel_upload":
                    this.buttons.upload.visible = true;
                    this.buttons.cancel_upload.visible = false;
                    OnezLoader.cancel();
                    if (ExternalInterface.available){
                        ExternalInterface.call("OnezCall", "status", "");
                    };
                    this.item.tip.text = "";
                    break;
                case "setting":
                    Security.showSettings(SecurityPanel.MICROPHONE);
                    break;
            };
        }
        private function mp3Loaded(e:Event):void{
            this.buttons.play.enabled = true;
            this.buttons.save.enabled = true;
            this.buttons.upload.enabled = true;
        }
        private function playComplete(e:Event):void{
            trace("playComplete");
            this.__click("stop_play");
        }
        private function uploadComplete(o:String):void{
            this.buttons.upload.visible = true;
            this.buttons.cancel_upload.visible = false;
            if (ExternalInterface.available){
                ExternalInterface.call("OnezCall", "upload", o);
            };
            this.item.tip.text = "";
        }
        private function uploadComplete2(o:Object):void{
            if (o.toString().substr(0, 2) == "ok"){
                OnezLoader.load(((Onez.info.siteurl + "/plugin.php?id=tsound_wenda&action=upload&t=") + Math.random()), this.uploadComplete, "text", {
                    size:this.mp3Data.length,
                    sec:this.sec,
                    rid:Onez.option("rid", "0"),
                    cloudurl:o.toString().substr(2)
                });
                this.item.tip.text = "正在提交...";
            } else {
                this.buttons.upload.visible = true;
                this.buttons.cancel_upload.visible = false;
                if (ExternalInterface.available){
                    ExternalInterface.call("OnezCall", "upload", o);
                };
                this.item.tip.text = "";
            };
        }

    }
}//package 
﻿package {
    import flash.text.*;

    public class Label extends TextField {

        public var textFormat:TextFormat;

        public function Label(text:String, color=null, size=null){
            super();
            if (color == null){
                color = 0x666666;
            };
            if (size == null){
                size = 12;
            };
            this.textFormat = new TextFormat();
            this.textFormat.font = "Arial";
            this.textFormat.size = size;
            this.autoSize = "left";
            this.textFormat.color = color;
            this.defaultTextFormat = this.textFormat;
            this.selectable = false;
            this.mouseEnabled = false;
            this.text = text;
        }
    }
}//package 
﻿package {
    import flash.display.*;
    import flash.events.*;
    import com.onez.common.*;
    import flash.net.*;

    public class LoadPane extends Sprite {

        private var click:Function;
        private var complate:Function;

        public function LoadPane(url:String, click:Function=null, complate:Function=null){
            super();
            this.click = click;
            this.complate = complate;
            var loader:Loader = new Loader();
            loader.cacheAsBitmap = true;
            loader.contentLoaderInfo.addEventListener(Event.COMPLETE, this.onComplete);
            trace(((Onez.info.siteurl + "/source/plugin/tsound_wenda/template/") + url));
            loader.load(new URLRequest(((((Onez.info.siteurl + "/source/plugin/tsound_wenda/template/") + url) + "?t=") + Math.random())));
            loader.mouseEnabled = false;
            if (click != null){
                addEventListener(MouseEvent.CLICK, this.onClick);
                this.buttonMode = true;
            };
            addChild(loader);
        }
        private function onComplete(e:Event):void{
            if (this.complate != null){
                this.complate.call();
            };
        }
        private function onClick(e:MouseEvent):void{
            if (this.click != null){
                this.click.call();
            };
        }

    }
}//package 
﻿package {
    import flash.display.*;
    import flash.events.*;

    public class Progress extends Sprite {

        private const h:Number = 2;

        private var box:Sprite;
        private var bar:Shape;
        private var scale:Number = 0;
        private var _color:uint;
        public var _value:Number = 0;

        public function Progress(){
            super();
            this.box = new Sprite();
            addChild(this.box);
            this.color = 65331;
            this.bar = new Shape();
            this.box.addChild(this.bar);
            this.addEventListener(ProgressEvent.PROGRESS, this.progress);
            visible = false;
        }
        public function get color():uint{
            return (this._color);
        }
        public function set color(value:uint):void{
            this._color = value;
            this.box.graphics.clear();
            this.box.graphics.beginFill(this.color, 0.1);
            this.box.graphics.drawRoundRect(0, 0, 395, this.h, this.h, this.h);
            this.box.graphics.endFill();
        }
        public function get value():Number{
            return (this._value);
        }
        public function set value(t:Number):void{
            dispatchEvent(new ProgressEvent(ProgressEvent.PROGRESS, false, false, t, 100));
        }
        private function progress(e:ProgressEvent):void{
            this.bar.graphics.clear();
            this.bar.graphics.beginFill(this.color, 0.5);
            this.bar.graphics.drawRoundRect(0, 0, ((this.box.width * e.bytesLoaded) / e.bytesTotal), this.h, this.h, this.h);
            this.bar.graphics.endFill();
            this.scale = (((e.bytesTotal > 0)) ? (e.bytesLoaded / e.bytesTotal) : 1);
            visible = (((this.scale > 0)) && ((this.scale < 1)));
        }

    }
}//package 
﻿package {
    import flash.display.*;
    import flash.events.*;
    import flash.net.*;
    import com.onez.common.*;

    public class Button extends Sprite {

        private var click:Function;
        private var upState:Loader;
        private var overState:Loader;
        private var step:int;
        private var offset:Array;
        private var _enabled:Boolean = true;

        public function Button(key:String, click:Function=null, step:int=-1){
            this.offset = [41, 128];
            super();
            this.click = click;
            this.step = step;
            this.upState = new Loader();
            this.upState.cacheAsBitmap = true;
            this.upState.contentLoaderInfo.addEventListener(Event.COMPLETE, this.onComplete);
            this.upState.load(new URLRequest(((((Onez.info.siteurl + "/source/plugin/tsound_wenda/template/images/") + key) + "_normal.png?t=") + Math.random())));
            this.upState.mouseEnabled = false;
            this.overState = new Loader();
            this.overState.cacheAsBitmap = true;
            this.overState.load(new URLRequest(((((Onez.info.siteurl + "/source/plugin/tsound_wenda/template/images/") + key) + "_hover.png?t=") + Math.random())));
            this.overState.mouseEnabled = false;
            this.overState.visible = false;
            addChild(this.upState);
            addChild(this.overState);
            addEventListener(MouseEvent.CLICK, this.onClick);
            addEventListener(MouseEvent.MOUSE_OVER, this.onOver);
            addEventListener(MouseEvent.MOUSE_OUT, this.onOut);
            buttonMode = true;
        }
        private function onComplete(e:Event):void{
            if (this.step != -1){
                this.x = (this.offset[0] + ((this.upState.width + 8) * this.step));
                this.y = this.offset[1];
            };
        }
        private function onClick(e:MouseEvent):void{
            if (!(this._enabled)){
                return;
            };
            if (this.click != null){
                this.click.call();
            };
        }
        private function onOver(e:MouseEvent):void{
            if (!(this._enabled)){
                return;
            };
            this.upState.visible = false;
            this.overState.visible = true;
        }
        private function onOut(e:MouseEvent):void{
            if (!(this._enabled)){
                return;
            };
            this.upState.visible = true;
            this.overState.visible = false;
        }
        public function get enabled():Boolean{
            return (this._enabled);
        }
        public function set enabled(value:Boolean):void{
            this._enabled = value;
            alpha = ((this.enabled) ? 1 : 0.3);
        }

    }
}//package 
﻿package org.bytearray.micrecorder {
    import flash.utils.*;
    import flash.events.*;
    import org.bytearray.micrecorder.events.*;
    import flash.media.*;

    public final class MicRecorder extends EventDispatcher {

        private var _gain:uint;
        private var _rate:uint;
        private var _silenceLevel:uint;
        private var _timeOut:uint;
        private var _difference:uint;
        private var _microphone:Microphone;
        private var _buffer:ByteArray;
        private var _output:ByteArray;
        private var _encoder:IEncoder;
        private var _completeEvent:Event;
        private var _recordingEvent:RecordingEvent;

        public function MicRecorder(encoder:IEncoder, microphone:Microphone=null, gain:uint=100, rate:uint=44, silenceLevel:uint=0, timeOut:uint=4000){
            this._buffer = new ByteArray();
            this._completeEvent = new Event(Event.COMPLETE);
            this._recordingEvent = new RecordingEvent(RecordingEvent.RECORDING, 0);
            super();
            this._encoder = encoder;
            this._microphone = microphone;
            this._gain = gain;
            this._rate = rate;
            this._silenceLevel = silenceLevel;
            this._timeOut = timeOut;
        }
        public function record():void{
            if (this._microphone == null){
                this._microphone = Microphone.getMicrophone();
            };
            this._difference = getTimer();
            this._microphone.setSilenceLevel(this._silenceLevel, this._timeOut);
            this._microphone.gain = this._gain;
            this._microphone.rate = this._rate;
            this._buffer.length = 0;
            this._microphone.addEventListener(SampleDataEvent.SAMPLE_DATA, this.onSampleData);
            this._microphone.addEventListener(StatusEvent.STATUS, this.onStatus);
        }
        public function pause(is_pause:Boolean=true):void{
            if (is_pause){
                this._microphone.removeEventListener(SampleDataEvent.SAMPLE_DATA, this.onSampleData);
                this._microphone.removeEventListener(StatusEvent.STATUS, this.onStatus);
            } else {
                this._microphone.addEventListener(SampleDataEvent.SAMPLE_DATA, this.onSampleData);
                this._microphone.addEventListener(StatusEvent.STATUS, this.onStatus);
                this._difference = getTimer();
            };
        }
        private function onStatus(event:StatusEvent):void{
            this._difference = getTimer();
        }
        private function onSampleData(event:SampleDataEvent):void{
            this._recordingEvent.time = (getTimer() - this._difference);
            dispatchEvent(this._recordingEvent);
            while (event.data.bytesAvailable > 0) {
                this._buffer.writeFloat(event.data.readFloat());
            };
        }
        public function stop():void{
            this._microphone.removeEventListener(SampleDataEvent.SAMPLE_DATA, this.onSampleData);
            this._buffer.position = 0;
            this._output = this._encoder.encode(this._buffer, 1);
            dispatchEvent(this._completeEvent);
        }
        public function get gain():uint{
            return (this._gain);
        }
        public function set gain(value:uint):void{
            this._gain = value;
        }
        public function get rate():uint{
            return (this._rate);
        }
        public function set rate(value:uint):void{
            this._rate = value;
        }
        public function get silenceLevel():uint{
            return (this._silenceLevel);
        }
        public function set silenceLevel(value:uint):void{
            this._silenceLevel = value;
        }
        public function get microphone():Microphone{
            return (this._microphone);
        }
        public function set microphone(value:Microphone):void{
            this._microphone = value;
        }
        public function get output():ByteArray{
            return (this._output);
        }
        override public function toString():String{
            return ((((((((((("[MicRecorder gain=" + this._gain) + " rate=") + this._rate) + " silenceLevel=") + this._silenceLevel) + " timeOut=") + this._timeOut) + " microphone:") + this._microphone) + "]"));
        }

    }
}//package org.bytearray.micrecorder 
﻿package org.bytearray.micrecorder.events {
    import flash.events.*;

    public final class RecordingEvent extends Event {

        public static const RECORDING:String = "recording";

        private var _time:Number;

        public function RecordingEvent(type:String, time:Number){
            super(type, false, false);
            this._time = time;
        }
        public function get time():Number{
            return (this._time);
        }
        public function set time(value:Number):void{
            this._time = value;
        }
        override public function clone():Event{
            return (new RecordingEvent(type, this._time));
        }

    }
}//package org.bytearray.micrecorder.events 
﻿package org.bytearray.micrecorder.encoder {
    import flash.utils.*;
    import org.bytearray.micrecorder.*;

    public class WaveEncoder implements IEncoder {

        private static const RIFF:String = "RIFF";
        private static const WAVE:String = "WAVE";
        private static const FMT:String = "fmt ";
        private static const DATA:String = "data";

        private var _bytes:ByteArray;
        private var _buffer:ByteArray;
        private var _volume:Number;

        public function WaveEncoder(volume:Number=1){
            this._bytes = new ByteArray();
            this._buffer = new ByteArray();
            super();
            this._volume = volume;
        }
        public function encode(samples:ByteArray, channels:int=2, bits:int=16, rate:int=44100):ByteArray{
            var data:ByteArray = this.create(samples);
            this._bytes.length = 0;
            this._bytes.endian = Endian.LITTLE_ENDIAN;
            this._bytes.writeUTFBytes(WaveEncoder.RIFF);
            this._bytes.writeInt(uint((data.length + 44)));
            this._bytes.writeUTFBytes(WaveEncoder.WAVE);
            this._bytes.writeUTFBytes(WaveEncoder.FMT);
            this._bytes.writeInt(uint(16));
            this._bytes.writeShort(uint(1));
            this._bytes.writeShort(channels);
            this._bytes.writeInt(rate);
            this._bytes.writeInt(uint(((rate * channels) * (bits >> 3))));
            this._bytes.writeShort(uint((channels * (bits >> 3))));
            this._bytes.writeShort(bits);
            this._bytes.writeUTFBytes(WaveEncoder.DATA);
            this._bytes.writeInt(data.length);
            this._bytes.writeBytes(data);
            this._bytes.position = 0;
            return (this._bytes);
        }
        private function create(bytes:ByteArray):ByteArray{
            this._buffer.endian = Endian.LITTLE_ENDIAN;
            this._buffer.length = 0;
            bytes.position = 0;
            while (bytes.bytesAvailable) {
                this._buffer.writeShort((bytes.readFloat() * (32767 * this._volume)));
            };
            return (this._buffer);
        }

    }
}//package org.bytearray.micrecorder.encoder 
﻿package org.bytearray.micrecorder {
    import flash.utils.*;

    public interface IEncoder {

        function encode(_arg1:ByteArray, _arg2:int=2, _arg3:int=16, _arg4:int=44100):ByteArray;

    }
}//package org.bytearray.micrecorder 
﻿package {
    import flash.net.*;
    import flash.display.*;
    import flash.events.*;
    import flash.utils.*;

    public final class OnezLoader {

        private static var _num:int = 0;
        private static var uploadLoader:URLLoader;

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
                postData.writeUTFBytes("Content-Type: audio/mpeg");
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
            uploadLoader = new URLLoader();
            uploadLoader.addEventListener(IOErrorEvent.IO_ERROR, Delegate.create(OnezComplete, complete));
            uploadLoader.addEventListener(Event.COMPLETE, Delegate.create(OnezComplete, complete));
            uploadLoader.addEventListener(SecurityErrorEvent.SECURITY_ERROR, Delegate.create(OnezComplete, complete));
            uploadLoader.load(req);
            num++;
        }
        public static function cancel():void{
            try {
                uploadLoader.close();
            } catch(e:Error) {
            };
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
                if (e.type == Event.COMPLETE){
                    complete(e.currentTarget.data);
                } else {
                    trace("OnezComplete", "error");
                    complete(null);
                };
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
}//package 
﻿package {
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
}//package 
﻿package cmodule.shine {

    public const _abort1:int;
    gshell = false;
    establishEnv();
    glogLvl = 0;
    this.gstackSize = (0x0400 * 0x0400);
    gfiles = {};
    this.gstaticInitter = new StaticInitter();
    this.inf = Number.POSITIVE_INFINITY;
    this.nan = Number.NaN;
    genv = {
        LANG:"en_US.UTF-8",
        TERM:"ansi"
    };
    gargs = ["a.out"];
    this.gstate = new MState(new Machine());
    this.mstate = gstate;
    this.gsetjmpMachine2ESPMap = new Dictionary(true);
    this.i__setjmp = exportSym("__setjmp", regFunc(FSM__setjmp.start));
    this.i_setjmp = exportSym("_setjmp", i__setjmp);
    this.i__longjmp = exportSym("__longjmp", regFunc(FSM__longjmp.start));
    this.i_longjmp = exportSym("_longjmp", i__longjmp);
    CTypemap.BufferType = new CBufferTypemap();
    CTypemap.SizedStrType = new CSizedStrUTF8Typemap();
    CTypemap.AS3ValType = new CAS3ValTypemap();
    CTypemap.VoidType = new CVoidTypemap();
    CTypemap.PtrType = new CPtrTypemap();
    CTypemap.IntType = new CIntTypemap();
    CTypemap.DoubleType = new CDoubleTypemap();
    CTypemap.StrType = new CStrUTF8Typemap();
    CTypemap.IntRefType = new CRefTypemap(CTypemap.IntType);
    CTypemap.DoubleRefType = new CRefTypemap(CTypemap.DoubleType);
    CTypemap.StrRefType = new CRefTypemap(CTypemap.StrType);
    this.i_AS3_Acquire = exportSym("_AS3_Acquire", new CProcTypemap(CTypemap.VoidType, [CTypemap.PtrType]).createC(CTypemap.AS3ValType.valueTracker.acquireId)[0]);
    this.i_AS3_Release = exportSym("_AS3_Release", new CProcTypemap(CTypemap.VoidType, [CTypemap.PtrType]).createC(CTypemap.AS3ValType.valueTracker.release)[0]);
    this.i_AS3_NSGet = exportSym("_AS3_NSGet", new CProcTypemap(CTypemap.AS3ValType, [CTypemap.AS3ValType, CTypemap.AS3ValType]).createC(AS3_NSGet)[0]);
    this.i_AS3_NSGetS = exportSym("_AS3_NSGetS", new CProcTypemap(CTypemap.AS3ValType, [CTypemap.AS3ValType, CTypemap.StrType]).createC(AS3_NSGet)[0]);
    this.i_AS3_TypeOf = exportSym("_AS3_TypeOf", new CProcTypemap(CTypemap.StrType, [CTypemap.AS3ValType]).createC(AS3_TypeOf)[0]);
    this.i_AS3_String = exportSym("_AS3_String", new CProcTypemap(CTypemap.AS3ValType, [CTypemap.StrType]).createC(AS3_NOP)[0]);
    this.i_AS3_StringN = exportSym("_AS3_StringN", new CProcTypemap(CTypemap.AS3ValType, [CTypemap.SizedStrType]).createC(AS3_NOP)[0]);
    this.i_AS3_Int = exportSym("_AS3_Int", new CProcTypemap(CTypemap.AS3ValType, [CTypemap.IntType]).createC(AS3_NOP)[0]);
    this.i_AS3_Ptr = exportSym("_AS3_Ptr", new CProcTypemap(CTypemap.AS3ValType, [CTypemap.PtrType]).createC(AS3_NOP)[0]);
    this.i_AS3_Number = exportSym("_AS3_Number", new CProcTypemap(CTypemap.AS3ValType, [CTypemap.DoubleType]).createC(AS3_NOP)[0]);
    this.i_AS3_True = exportSym("_AS3_True", new CProcTypemap(CTypemap.AS3ValType, []).createC(function ():Boolean{
        return (true);
    })[0]);
    this.i_AS3_False = exportSym("_AS3_False", new CProcTypemap(CTypemap.AS3ValType, []).createC(function ():Boolean{
        return (false);
    })[0]);
    this.i_AS3_Null = exportSym("_AS3_Null", new CProcTypemap(CTypemap.AS3ValType, []).createC(function (){
        return (null);
    })[0]);
    this.i_AS3_Undefined = exportSym("_AS3_Undefined", new CProcTypemap(CTypemap.AS3ValType, []).createC(function (){
        return (undefined);
    })[0]);
    this.i_AS3_StringValue = exportSym("_AS3_StringValue", new CProcTypemap(CTypemap.StrType, [CTypemap.AS3ValType]).createC(AS3_NOP)[0]);
    this.i_AS3_IntValue = exportSym("_AS3_IntValue", new CProcTypemap(CTypemap.IntType, [CTypemap.AS3ValType]).createC(AS3_NOP)[0]);
    this.i_AS3_PtrValue = exportSym("_AS3_PtrValue", new CProcTypemap(CTypemap.PtrType, [CTypemap.AS3ValType]).createC(AS3_NOP)[0]);
    this.i_AS3_NumberValue = exportSym("_AS3_NumberValue", new CProcTypemap(CTypemap.DoubleType, [CTypemap.AS3ValType]).createC(AS3_NOP)[0]);
    this.i_AS3_Get = exportSym("_AS3_Get", new CProcTypemap(CTypemap.AS3ValType, [CTypemap.AS3ValType, CTypemap.AS3ValType]).createC(AS3_Get)[0]);
    this.i_AS3_GetS = exportSym("_AS3_GetS", new CProcTypemap(CTypemap.AS3ValType, [CTypemap.AS3ValType, CTypemap.StrType]).createC(AS3_Get)[0]);
    this.i_AS3_Set = exportSym("_AS3_Set", new CProcTypemap(CTypemap.VoidType, [CTypemap.AS3ValType, CTypemap.AS3ValType, CTypemap.AS3ValType]).createC(AS3_Set)[0]);
    this.i_AS3_SetS = exportSym("_AS3_SetS", new CProcTypemap(CTypemap.VoidType, [CTypemap.AS3ValType, CTypemap.StrType, CTypemap.AS3ValType]).createC(AS3_Set)[0]);
    this.i_AS3_Array = exportSym("_AS3_Array", new CProcTypemap(CTypemap.AS3ValType, [CTypemap.StrType], true).createC(AS3_Array)[0]);
    this.i_AS3_Object = exportSym("_AS3_Object", new CProcTypemap(CTypemap.AS3ValType, [CTypemap.StrType], true).createC(AS3_Object)[0]);
    this.i_AS3_Call = exportSym("_AS3_Call", new CProcTypemap(CTypemap.AS3ValType, [CTypemap.AS3ValType, CTypemap.AS3ValType, CTypemap.AS3ValType]).createC(AS3_Call)[0]);
    this.i_AS3_CallS = exportSym("_AS3_CallS", new CProcTypemap(CTypemap.AS3ValType, [CTypemap.StrType, CTypemap.AS3ValType, CTypemap.AS3ValType]).createC(AS3_CallS)[0]);
    this.i_AS3_CallT = exportSym("_AS3_CallT", new CProcTypemap(CTypemap.AS3ValType, [CTypemap.AS3ValType, CTypemap.AS3ValType, CTypemap.StrType], true).createC(AS3_CallT)[0]);
    this.i_AS3_CallTS = exportSym("_AS3_CallTS", new CProcTypemap(CTypemap.AS3ValType, [CTypemap.StrType, CTypemap.AS3ValType, CTypemap.StrType], true).createC(AS3_CallTS)[0]);
    this.i_AS3_Shim = exportSym("_AS3_Shim", new CProcTypemap(CTypemap.PtrType, [CTypemap.AS3ValType, CTypemap.AS3ValType, CTypemap.StrType, CTypemap.StrType, CTypemap.IntType]).createC(AS3_Shim)[0]);
    this.i_AS3_New = exportSym("_AS3_New", new CProcTypemap(CTypemap.AS3ValType, [CTypemap.AS3ValType, CTypemap.AS3ValType]).createC(AS3_New)[0]);
    this.i_AS3_Function = exportSym("_AS3_Function", new CProcTypemap(CTypemap.AS3ValType, [CTypemap.PtrType, new CProcTypemap(CTypemap.AS3ValType, [CTypemap.PtrType, CTypemap.AS3ValType])]).createC(AS3_Function)[0]);
    this.i_AS3_FunctionAsync = exportSym("_AS3_FunctionAsync", new CProcTypemap(CTypemap.AS3ValType, [CTypemap.PtrType, new CProcTypemap(CTypemap.AS3ValType, [CTypemap.PtrType, CTypemap.AS3ValType], false, true)]).createC(AS3_FunctionAsync)[0]);
    this.i_AS3_FunctionT = exportSym("_AS3_FunctionT", new CProcTypemap(CTypemap.AS3ValType, [CTypemap.PtrType, CTypemap.PtrType, CTypemap.StrType, CTypemap.StrType, CTypemap.IntType]).createC(AS3_FunctionT)[0]);
    this.i_AS3_FunctionAsyncT = exportSym("_AS3_FunctionAsyncT", new CProcTypemap(CTypemap.AS3ValType, [CTypemap.PtrType, CTypemap.PtrType, CTypemap.StrType, CTypemap.StrType, CTypemap.IntType]).createC(AS3_FunctionAsyncT)[0]);
    this.i_AS3_InstanceOf = exportSym("_AS3_InstanceOf", new CProcTypemap(CTypemap.IntType, [CTypemap.AS3ValType, CTypemap.AS3ValType]).createC(AS3_InstanceOf)[0]);
    this.i_AS3_Stage = exportSym("_AS3_Stage", new CProcTypemap(CTypemap.AS3ValType, []).createC(AS3_Stage)[0]);
    this.i_AS3_ArrayValue = exportSym("_AS3_ArrayValue", new CProcTypemap(CTypemap.VoidType, [CTypemap.AS3ValType, CTypemap.StrType], true).createC(AS3_ArrayValue)[0]);
    this.i_AS3_ObjectValue = exportSym("_AS3_ObjectValue", new CProcTypemap(CTypemap.VoidType, [CTypemap.AS3ValType, CTypemap.StrType], true).createC(AS3_ObjectValue)[0]);
    this.i_AS3_Proxy = exportSym("_AS3_Proxy", new CProcTypemap(CTypemap.AS3ValType, [], false).createC(AS3_Proxy)[0]);
    this.i_AS3_Ram = exportSym("_AS3_Ram", new CProcTypemap(CTypemap.AS3ValType, [], false).createC(AS3_Ram)[0]);
    this.i_AS3_ByteArray_readBytes = exportSym("_AS3_ByteArray_readBytes", new CProcTypemap(CTypemap.IntType, [CTypemap.IntType, CTypemap.AS3ValType, CTypemap.IntType], false).createC(AS3_ByteArray_readBytes)[0]);
    this.i_AS3_ByteArray_writeBytes = exportSym("_AS3_ByteArray_writeBytes", new CProcTypemap(CTypemap.IntType, [CTypemap.AS3ValType, CTypemap.IntType, CTypemap.IntType], false).createC(AS3_ByteArray_writeBytes)[0]);
    this.i_AS3_ByteArray_seek = exportSym("_AS3_ByteArray_seek", new CProcTypemap(CTypemap.IntType, [CTypemap.AS3ValType, CTypemap.IntType, CTypemap.IntType], false).createC(AS3_ByteArray_seek)[0]);
    this.i_AS3_Trace = exportSym("_AS3_Trace", new CProcTypemap(CTypemap.VoidType, [CTypemap.AS3ValType], false).createC(trace)[0]);
    this.i_AS3_Reg_jmp_buf_AbuseHelpers = exportSym("_AS3_Reg_jmp_buf_AbuseHelpers", new CProcTypemap(CTypemap.VoidType, [new CProcTypemap(CTypemap.PtrType, [CTypemap.IntType]), new CProcTypemap(CTypemap.VoidType, [CTypemap.PtrType])], false).createC(AS3_Reg_jmp_buf_AbuseHelpers)[0]);
    this.i_AS3_RegAbused_jmp_buf = exportSym("_AS3_RegAbused_jmp_buf", new CProcTypemap(CTypemap.VoidType, [CTypemap.PtrType], false).createC(AS3_RegAbused_jmp_buf)[0]);
    this.i_AS3_UnregAbused_jmp_buf = exportSym("_AS3_UnregAbused_jmp_buf", new CProcTypemap(CTypemap.VoidType, [CTypemap.PtrType], false).createC(AS3_UnregAbused_jmp_buf)[0]);
    vglKeys = [];
    vglKeyFirst = true;
    vglMouseFirst = true;
    this.__fini = regFunc(FSM__fini.start);
    this.___error = regFunc(FSM___error.start);
    this._ioctl = regFunc(FSM_ioctl.start);
    this._fstat = regFunc(FSM_fstat.start);
    this.__exit = regFunc(FSM__exit.start);
    this._sprintf = regFunc(FSM_sprintf.start);
    this.__start = regFunc(FSM__start.start);
    this._atexit = regFunc(FSM_atexit.start);
    this._exit = regFunc(FSM_exit.start);
    this._dorounding = regFunc(FSM_dorounding.start);
    this._abort1 = regFunc(FSM_abort1.start);
    this.___gdtoa = regFunc(FSM___gdtoa.start);
    this.___quorem_D2A = regFunc(FSM___quorem_D2A.start);
    this.___Balloc_D2A = regFunc(FSM___Balloc_D2A.start);
    this.___pow5mult_D2A = regFunc(FSM___pow5mult_D2A.start);
    this.___mult_D2A = regFunc(FSM___mult_D2A.start);
    this.___lshift_D2A = regFunc(FSM___lshift_D2A.start);
    this.___multadd_D2A = regFunc(FSM___multadd_D2A.start);
    this.___diff_D2A = regFunc(FSM___diff_D2A.start);
    this.___lo0bits_D2A = regFunc(FSM___lo0bits_D2A.start);
    this.___trailz_D2A = regFunc(FSM___trailz_D2A.start);
    this._fprintf = regFunc(FSM_fprintf.start);
    this._getenv = regFunc(FSM_getenv.start);
    this._bcopy = regFunc(FSM_bcopy.start);
    this._fclose = regFunc(FSM_fclose.start);
    this._fflush = regFunc(FSM_fflush.start);
    this._free = regFunc(FSM_free.start);
    this._fread = regFunc(FSM_fread.start);
    this.__UTF8_wcrtomb = regFunc(FSM__UTF8_wcrtomb.start);
    this.___adddi3 = regFunc(FSM___adddi3.start);
    this.___anddi3 = regFunc(FSM___anddi3.start);
    this.___ashldi3 = regFunc(FSM___ashldi3.start);
    this.___ashrdi3 = regFunc(FSM___ashrdi3.start);
    this.___cmpdi2 = regFunc(FSM___cmpdi2.start);
    this.___divdi3 = regFunc(FSM___divdi3.start);
    this.___qdivrem = regFunc(FSM___qdivrem.start);
    this.___fixdfdi = regFunc(FSM___fixdfdi.start);
    this.___fixsfdi = regFunc(FSM___fixsfdi.start);
    this.___fixunsdfdi = regFunc(FSM___fixunsdfdi.start);
    this.___fixunssfdi = regFunc(FSM___fixunssfdi.start);
    this.___floatdidf = regFunc(FSM___floatdidf.start);
    this.___floatdisf = regFunc(FSM___floatdisf.start);
    this.___floatunsdidf = regFunc(FSM___floatunsdidf.start);
    this.___iordi3 = regFunc(FSM___iordi3.start);
    this.___lshldi3 = regFunc(FSM___lshldi3.start);
    this.___lshrdi3 = regFunc(FSM___lshrdi3.start);
    this.___moddi3 = regFunc(FSM___moddi3.start);
    this.___lmulq = regFunc(FSM___lmulq.start);
    this.___muldi3 = regFunc(FSM___muldi3.start);
    this.___negdi2 = regFunc(FSM___negdi2.start);
    this.___one_cmpldi2 = regFunc(FSM___one_cmpldi2.start);
    this.___subdi3 = regFunc(FSM___subdi3.start);
    this.___ucmpdi2 = regFunc(FSM___ucmpdi2.start);
    this.___udivdi3 = regFunc(FSM___udivdi3.start);
    this.___umoddi3 = regFunc(FSM___umoddi3.start);
    this.___xordi3 = regFunc(FSM___xordi3.start);
    this.___vfprintf = regFunc(FSM___vfprintf.start);
    this.___sflush = regFunc(FSM___sflush.start);
    this.___sfp = regFunc(FSM___sfp.start);
    this.___sread = regFunc(FSM___sread.start);
    this.___swrite = regFunc(FSM___swrite.start);
    this.___sseek = regFunc(FSM___sseek.start);
    this.___sclose = regFunc(FSM___sclose.start);
    this.__swrite = regFunc(FSM__swrite.start);
    this.___fflush = regFunc(FSM___fflush.start);
    this.___srefill = regFunc(FSM___srefill.start);
    this.__cleanup = regFunc(FSM__cleanup.start);
    this.__sseek = regFunc(FSM__sseek.start);
    this._fputc = regFunc(FSM_fputc.start);
    this.___swbuf = regFunc(FSM___swbuf.start);
    this.___sfvwrite = regFunc(FSM___sfvwrite.start);
    this.___swsetup = regFunc(FSM___swsetup.start);
    this.__fseeko = regFunc(FSM__fseeko.start);
    this._fseek = regFunc(FSM_fseek.start);
    this.__ftello = regFunc(FSM__ftello.start);
    this.___smakebuf = regFunc(FSM___smakebuf.start);
    this._ftell = regFunc(FSM_ftell.start);
    this._printf = regFunc(FSM_printf.start);
    this.___ultoa = regFunc(FSM___ultoa.start);
    this.___grow_type_table = regFunc(FSM___grow_type_table.start);
    this.___find_arguments = regFunc(FSM___find_arguments.start);
    this._malloc_pages = regFunc(FSM_malloc_pages.start);
    this._ifree = regFunc(FSM_ifree.start);
    this._imalloc = regFunc(FSM_imalloc.start);
    this._pubrealloc = regFunc(FSM_pubrealloc.start);
    this._malloc = regFunc(FSM_malloc.start);
    this._readByteArray = regFunc(FSM_readByteArray.start);
    this._writeByteArray = regFunc(FSM_writeByteArray.start);
    this._seekByteArray = regFunc(FSM_seekByteArray.start);
    this._closeByteArray = regFunc(FSM_closeByteArray.start);
    this._init = regFunc(FSM_init.start);
    this._update = regFunc(FSM_update.start);
    this._main189 = regFunc(FSM_main189.start);
    this._wave_get = regFunc(FSM_wave_get.start);
    this._wave_open = regFunc(FSM_wave_open.start);
    this._Read16BitsLowHigh = regFunc(FSM_Read16BitsLowHigh.start);
    this._start_compress = regFunc(FSM_start_compress.start);
    this._update_compress = regFunc(FSM_update_compress.start);
    this._filter_subband = regFunc(FSM_filter_subband.start);
    this._subband_initialise = regFunc(FSM_subband_initialise.start);
    this._putMyBits = regFunc(FSM_putMyBits.start);
    this._BF_addEntry = regFunc(FSM_BF_addEntry.start);
    this._BF_newPartHolder = regFunc(FSM_BF_newPartHolder.start);
    this._writePartSideInfo = regFunc(FSM_writePartSideInfo.start);
    this._write_side_info = regFunc(FSM_write_side_info.start);
    this._writePartMainData = regFunc(FSM_writePartMainData.start);
    this._mdct_initialise = regFunc(FSM_mdct_initialise.start);
    this._new_choose_table = regFunc(FSM_new_choose_table.start);
    this._DetermineByteOrder = regFunc(FSM_DetermineByteOrder.start);
    this.__2E_str = gstaticInitter.alloc(6, 1);
    this.__2E_str1 = gstaticInitter.alloc(6, 1);
    this._val_2E_1440 = gstaticInitter.alloc(4, 4);
    this.__2E_str8 = gstaticInitter.alloc(8, 1);
    this.__2E_str19 = gstaticInitter.alloc(7, 1);
    this.__2E_str210 = gstaticInitter.alloc(10, 1);
    this.__2E_str37 = gstaticInitter.alloc(5, 1);
    this.__2E_str138 = gstaticInitter.alloc(14, 1);
    this.__2E_str340 = gstaticInitter.alloc(12, 1);
    this.__2E_str643 = gstaticInitter.alloc(10, 1);
    this.__2E_str251 = gstaticInitter.alloc(12, 1);
    this.__2E_str876 = gstaticInitter.alloc(10, 1);
    this.__2E_str977 = gstaticInitter.alloc(7, 1);
    this.__2E_str13 = gstaticInitter.alloc(14, 1);
    this.__2E_str96 = gstaticInitter.alloc(23, 1);
    this._environ = gstaticInitter.alloc(4, 4);
    this.__2E_str45 = gstaticInitter.alloc(1, 1);
    this.__2E_str159 = gstaticInitter.alloc(9, 1);
    this.__2E_str260 = gstaticInitter.alloc(4, 1);
    this.___tens_D2A = gstaticInitter.alloc(184, 8);
    this.___bigtens_D2A = gstaticInitter.alloc(40, 8);
    this._freelist = gstaticInitter.alloc(64, 4);
    this._pmem_next = gstaticInitter.alloc(4, 4);
    this._private_mem = gstaticInitter.alloc(0x0900, 8);
    this._p05_2E_3773 = gstaticInitter.alloc(12, 4);
    this._p5s = gstaticInitter.alloc(4, 4);
    this.__2E_str1670 = gstaticInitter.alloc(56, 1);
    this.___mlocale_changed_2E_b = gstaticInitter.alloc(1, 1);
    this.__2E_str20159 = gstaticInitter.alloc(2, 1);
    this._numempty22 = gstaticInitter.alloc(2, 1);
    this.___nlocale_changed_2E_b = gstaticInitter.alloc(1, 1);
    this._ret_2E_1494_2E_0_2E_b = gstaticInitter.alloc(1, 1);
    this._ret_2E_1494_2E_2_2E_b = gstaticInitter.alloc(1, 1);
    this.___sF = gstaticInitter.alloc(264, 8);
    this.___sdidinit_2E_b = gstaticInitter.alloc(1, 1);
    this._usual_extra = gstaticInitter.alloc(2516, 8);
    this._usual = gstaticInitter.alloc(1496, 8);
    this.___cleanup_2E_b = gstaticInitter.alloc(1, 1);
    this._empty_2E_3904 = gstaticInitter.alloc(88, 8);
    this._emptyx_2E_3905 = gstaticInitter.alloc(148, 8);
    this.___sglue = gstaticInitter.alloc(12, 8);
    this._uglue = gstaticInitter.alloc(12, 8);
    this.___sFX = gstaticInitter.alloc(444, 8);
    this._lastglue = gstaticInitter.alloc(4, 4);
    this._initial_2E_4576 = gstaticInitter.alloc(128, 8);
    this._xdigs_lower_2E_4528 = gstaticInitter.alloc(17, 1);
    this._xdigs_upper_2E_4529 = gstaticInitter.alloc(17, 1);
    this.__2E_str118283 = gstaticInitter.alloc(4, 1);
    this.__2E_str219284 = gstaticInitter.alloc(4, 1);
    this.__2E_str320285 = gstaticInitter.alloc(4, 1);
    this.__2E_str421 = gstaticInitter.alloc(4, 1);
    this.__2E_str522 = gstaticInitter.alloc(7, 1);
    this._blanks_2E_4526 = gstaticInitter.alloc(16, 1);
    this._zeroes_2E_4527 = gstaticInitter.alloc(16, 1);
    this.___atexit = gstaticInitter.alloc(4, 4);
    this.___atexit0_2E_3021 = gstaticInitter.alloc(520, 8);
    this._free_list = gstaticInitter.alloc(20, 8);
    this._malloc_origo = gstaticInitter.alloc(4, 4);
    this._last_index = gstaticInitter.alloc(4, 4);
    this._malloc_brk = gstaticInitter.alloc(4, 4);
    this._malloc_ninfo = gstaticInitter.alloc(4, 4);
    this._page_dir = gstaticInitter.alloc(4, 4);
    this._malloc_junk_2E_b = gstaticInitter.alloc(1, 1);
    this._px = gstaticInitter.alloc(4, 4);
    this._malloc_zero_2E_b = gstaticInitter.alloc(1, 1);
    this._malloc_hint_2E_b = gstaticInitter.alloc(1, 1);
    this._malloc_cache = gstaticInitter.alloc(4, 4);
    this._malloc_active_2E_3509 = gstaticInitter.alloc(4, 4);
    this._malloc_started_2E_3510_2E_b = gstaticInitter.alloc(1, 1);
    this.__2E_str113335 = gstaticInitter.alloc(15, 1);
    this._malloc_realloc_2E_b = gstaticInitter.alloc(1, 1);
    this._malloc_sysv_2E_b = gstaticInitter.alloc(1, 1);
    this.__2E_str7403 = gstaticInitter.alloc(13, 1);
    this.__2E_str99 = gstaticInitter.alloc(9, 1);
    this.__2E_str1100 = gstaticI