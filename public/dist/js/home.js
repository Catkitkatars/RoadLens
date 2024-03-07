import{L as t}from"./index.js";function m(e){return`
    <div class="side_camera_block">
        <span class="icon-closed material-symbols-outlined">
        close
        </span>
        <div class="info-box">
            <h3 class="name-block_h3">Инфо</h3>
            <div class="info-box_specification">
                <p>UUID:</p>
                <div class="line-style"></div>
                <h5>${e.properties.id}</h5>
            </div>
            <div class="info-box_specification">
                <p>Тип:</p>
                <div class="line-style"></div>
                <h5>${e.properties.type}</h5>
            </div>
            <div class="info-box_specification">
                <p>Модель:</p>
                <div class="line-style"></div>
                <h5>${e.properties.model}</h5>
            </div>
            <div class="info-box_specification">
                <p>Направление:</p>
                <div class="line-style"></div>
                <h5>${e.properties.direction}</h5>
            </div>
            <div class="info-box_specification">
                <p>Скорость:</p>
                <div class="line-style"></div>
                <h5>${e.properties.speed}</h5>
            </div>
            <div class="info-box_specification">
                <p>Дата создания:</p>
                <div class="line-style"></div>
                <h5>${e.properties.dateCreate}</h5>
            </div>
            <div class="info-box_specification">
                <p>Дата последних изменений:</p>
                <div class="line-style"></div>
                <h5>${e.properties.lastUpdate}</h5>
            </div>
            <div class="edit-submit">
                <a href="#">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    Изменить
                </a>
            </div>
        </div>
    </div>`}var o=t.map("map",{center:[52.43369,6.83442],zoom:17});t.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png",{attribution:'&copy; <a href="#">RoadLens</a>'}).addTo(o);let c=o.getCenter(),v=o.getZoom(),f=`http://localhost:8080/map/${c.lat.toFixed(6)}/${c.lng.toFixed(6)}/${v}`;window.history.replaceState({},"",f);o.on("moveend",function(e){var n=o.getCenter(),s=o.getZoom(),r=`http://localhost:8080/map/${n.lat.toFixed(6)}/${n.lng.toFixed(6)}/${s}`;window.history.replaceState({},"",r)});var y=t.Control.extend({options:{position:"bottomright"},onAdd:function(e){var n=t.DomUtil.create("div","addButton");let s=t.DomUtil.create("a","button-add",n);return s.innerHTML="Добавить камеру",t.DomEvent.on(s,"click",function(){alert("Вы нажали кнопку!")}),n}});o.addControl(new y);let i={point1:{id:1,type:"Маломощный",model:"Автоураган",direction:"В спину",speed:60,dateCreate:"18.02.2024",lastUpdate:"20.02.2024",camera:[6.82775,52.43377],target:[6.83085,52.43385]},point2:{id:2,type:"Стационарный",model:"Кордон",direction:"В лоб",speed:80,dateCreate:"16.02.2024",lastUpdate:"22.02.2024",camera:[6.83003,52.43382],target:[6.82691,52.43369]},point3:{id:3,type:"Контроль светофора",model:"Кордон",direction:"В лоб",speed:40,dateCreate:"10.02.2024",lastUpdate:"10.02.2024",camera:[6.83146,52.43525],target:[6.83241,52.43388]},point4:{id:4,type:"Видеоблок",model:"Стрелка",direction:"В спину",speed:0,dateCreate:"14.02.2024",lastUpdate:"14.02.2024",camera:[6.83489,52.43356],target:[6.83276,52.43377]},point5:{id:5,type:"Тренога",model:"Скат",direction:"В спину",speed:90,dateCreate:"01.02.2024",lastUpdate:"13.02.2024",camera:[6.83337,52.43309],target:[6.83428,52.43131]}};var h={draggable:!1,control:!1,cameraIcon:t.icon({iconUrl:"/dist/images/main-pin.png",iconSize:[38,38],iconAnchor:[19,35]}),targetIcon:t.icon({iconUrl:"/dist/images/marker.svg",iconSize:[0,0],iconAnchor:[16,16]}),angleIcon:t.icon({iconUrl:"/dist/images/marker.svg",iconSize:[0,0],iconAnchor:[16,16]}),outlineStyle:{color:"#03e9f4",opacity:0,weight:2,dashArray:"1, 1",lineCap:"round",lineJoin:"round"},fillStyle:{weight:0,fillOpacity:.3,fillColor:"#032b2d"}};let d=t.layerGroup(),p=t.layerGroup(),l=document.querySelector(".section_camera_info"),a=null;for(let e in i){let n={type:"Feature",properties:{angle:20,id:i[e].id,type:i[e].type,model:i[e].model,direction:i[e].direction,speed:i[e].speed,dateCreate:i[e].dateCreate,lastUpdate:i[e].lastUpdate},geometry:{type:"GeometryCollection",geometries:[{type:"Point",coordinates:i[e].camera},{type:"Point",coordinates:i[e].target}]}},s=t.geotagPhoto.camera(n,h).on("click",function(r){a===this?(this.setStyle({fillColor:"#032b2d",fillOpacity:.3}),a=null,l.classList.remove("section_camera_info_move"),l.innerHTML=""):(a&&(a.setStyle({fillColor:"#032b2d",fillOpacity:.3}),l.classList.remove("section_camera_info_move"),l.innerHTML=""),this.setStyle({fillColor:"#056c71",fillOpacity:.7}),a=this,l.classList.add("section_camera_info_move"),l.innerHTML=m(n),document.querySelector(".icon-closed").addEventListener("click",()=>{l.classList.remove("section_camera_info_move"),l.innerHTML="",a.setStyle({fillColor:"#032b2d",fillOpacity:.3}),a=null}))}).on("mouseover",function(r){a!=this&&this.setStyle({fillOpacity:.6})}).on("mouseout",function(r){a!=this&&this.setStyle({fillOpacity:.3})});d.addLayer(s)}d.addTo(o);p.addTo(o);let g={гибдд:d,видео:p};t.control.layers(null,g).addTo(o);
