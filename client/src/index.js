import {NewsApi} from './news'

let getAllBtn        = document.querySelector(".getAll");
let getOneBtn        = document.querySelector(".getOne");
let addBtn           = document.querySelector(".add");
let updateBtn        = document.querySelector(".update");
let deleteBtn        = document.querySelector(".delete");
let output           = document.querySelector(".container");
let idInput          = document.querySelector("#article-id");
let titleInput       = document.querySelector("#title");
let contentidInput   = document.querySelector("#content");

let news = new NewsApi('http://localhost/js/pro/api/server/');

getAllBtn.addEventListener('click', () => news.getAll().catch(console.warn));

getOneBtn.addEventListener('click', () => news.get(idInput.value).catch(console.warn));

addBtn.addEventListener('click',    () => news.add(titleInput.value, contentidInput.value).catch(console.warn));

updateBtn.addEventListener('click', () => news.get(idInput.value, titleInput.value, contentidInput.value).catch(console.warn));

deleteBtn.addEventListener('click', () => news.delete(idInput.value).catch(console.warn));

