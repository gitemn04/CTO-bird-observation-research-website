<?php include "config/auth.php"; ?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CTO Bird Observation</title>

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>

/* ================= GLOBAL ================= */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: 'Poppins', sans-serif;
}

body{
    background: linear-gradient(to right, #e0f2fe, #f0f9ff);
    min-height:100vh;
}

/* ================= NAVBAR ================= */
header{
    background: linear-gradient(90deg,#1e3a8a,#2563eb);
    padding:15px 50px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    color:white;
    box-shadow:0 5px 15px rgba(0,0,0,0.2);
}

header h2{
    font-weight:600;
}

nav a{
    color:white;
    text-decoration:none;
    margin-left:25px;
    font-weight:500;
    transition:0.3s;
}

nav a:hover{
    color:#fde047;
}

/* ================= HERO ================= */
.hero{
    height:60vh;
    background:url("https://images.unsplash.com/photo-1501706362039-c6e80948bb6b") center/cover no-repeat;
    display:flex;
    align-items:center;
    justify-content:center;
    text-align:center;
    color:white;
    position:relative;
}

.hero::after{
    content:"";
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.5);
}

.hero-content{
    position:relative;
    z-index:2;
}

.hero h1{
    font-size:40px;
    margin-bottom:15px;
}

.hero p{
    font-size:18px;
}

/* ================= SECTIONS ================= */
.section{
    display:none;
    padding:60px 20px;
    animation:fadeIn 0.5s ease-in-out;
}

.active{
    display:block;
}

@keyframes fadeIn{
    from{opacity:0; transform:translateY(20px);}
    to{opacity:1; transform:translateY(0);}
}

/* ================= CARD ================= */
.card{
    max-width:600px;
    margin:20px auto;
    padding:30px;
    border-radius:15px;
    background:rgba(255,255,255,0.8);
    backdrop-filter: blur(10px);
    box-shadow:0 8px 25px rgba(0,0,0,0.1);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

/* ================= FORM ================= */
input, select, textarea{
    width:100%;
    padding:10px;
    margin:10px 0;
    border-radius:8px;
    border:1px solid #ccc;
}

button{
    padding:10px 18px;
    border:none;
    border-radius:8px;
    background:linear-gradient(90deg,#1e3a8a,#2563eb);
    color:white;
    cursor:pointer;
    font-weight:500;
    transition:0.3s;
}

button:hover{
    background:linear-gradient(90deg,#2563eb,#1e40af);
    transform:scale(1.05);
}

.small-btn{
    font-size:12px;
    padding:6px 10px;
    margin-top:5px;
}

/* ================= POSTS ================= */
.post-card{
    margin-top:15px;
    padding:15px;
    background:white;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

/* ================= RESPONSIVE ================= */
@media(max-width:768px){
    header{
        flex-direction:column;
    }
    nav{
        margin-top:10px;
    }
}

</style>
</head>
<body>

<header>
    <h2>CTO Bird Study</h2>
    <nav>
        <a onclick="showSection('home')">Home</a>
        <a onclick="showSection('register')">Register</a>
        <a onclick="showSection('login')">Login</a>
        <a onclick="showSection('create')">New Post</a> 
        <a onclick="showSection('board')">Message Board</a>
        <a onclick="showSection('posts')">View Posts</a>
        <a onclick="showSection('stats')">Statistics</a>
    </nav>
</header>


<!-- STATISTICS -->

<div id="stats" class="section">
    <div class="card">
        <h2>Bird Observation Statistics</h2>
        <p id="totalPosts"></p>
    </div>
</div>


 <!-- MESSAGE BOARD -->
  <nav>
<div id="board" class="section">
    <div class="card">
        <h2>Community Message Board</h2>
         
        <input type="text" id="msgUser" placeholder="Your Name">
        <textarea id="msgText" placeholder="Write your message..."></textarea>
        <button onclick="addMessage()">Post Message</button>

        <div id="messageList"></div>
    </div>
</div>
</nav>








<!-- HERO -->
<div id="home" class="section active">
    <div class="hero">
        <div class="hero-content">
            <h1>Explore Birdlife in Centrala</h1>
            <p>Contribute your observations and support environmental research.</p>
        </div>
    </div>
</div>

<!-- REGISTER --><!-- REGISTER -->
<div id="register" class="section">
    <div class="card">
        <h2>User Registration</h2>

        <form>

            <label for="regUsername">Username</label>
            <input type="text" id="regUsername" required>

            <label for="regPassword">Password</label>
            <input type="password" id="regPassword" required>

            <button type="button" onclick="registerUser()">Register</button>

        </form>

    </div>
</div>
<!-- LOGIN -->
<div id="login" class="section">
    <div class="card">
        <h2>User Login</h2>

        <label for="loginUsername">Username</label>
        <input type="text" id="loginUsername" required>

        <label for="loginPassword">Password</label>
        <input type="password" id="loginPassword" required>

        <button onclick="loginUser()">Login</button>

        <!-- Reset Password Button -->
        <button onclick="resetPassword()" 
                style="margin-top:10px; background-color:#f44336; color:white;">
            Reset Password
        </button>

        <p id="loginMessage"></p>

    </div>
</div>
<!-- CREATE POST -->
<div id="create" class="section">
    <div class="card">
        <h2>Submit Bird Observation</h2>

        <form>

            <label for="username">Username</label>
            <input type="text" id="username" required>
            <label for="location">Location</label>
            <select id="location" required>
                <option value="" disabled selected>Select Location</option>
                <option>Erean</option>
                <option>Brunad</option>
                <option>Bylyn</option>
                <option>Docia</option>
                <option>Marend</option>
                <option>Pryn</option>
                <option>Zord</option>
                <option>Yaean</option>
                <option>Frestin</option>
                <option>Stonyam</option>
                <option>Ryall</option>
                <option>Ruril</option>
                <option>Keivia</option>
                <option>Tallan</option>
                <option>Adohad</option>
                <option>Obelyn</option>
                <option>Holmer</option>
                <option>Vertwall</option>
            </select>
            <label for="date">Date</label>
            <input type="date" id="date">

            <label for="time">Time</label>
            <input type="time" id="time">

            <label for="bird">Bird Species</label>
            <select id="bird">
                <option value="" disabled selected>Select Bird Species</option>
                <option>Wood Pigeon</option>
                <option>House Sparrow</option>
                <option>Starling</option>
                <option>Blue Tit</option>
                <option>Blackbird</option>
                <option>Robin</option>
                <option>Goldfinch</option>
                <option>Magpie</option>
                <option>Other/Unknown</option>
            </select>

            <label for="activity">Primary Activity</label>
            <select id="activity">
                <option value="" disabled selected>Primary Activity</option>
                <option>Visit</option>
                <option>Feeding</option>
                <option>Nesting</option>
                <option>Other</option>
            </select>
            
            <label for="duration">Duration (minutes)</label>
            <input type="number" id="duration">
            
            <label for="comments">Comments</label>
            <textarea id="comments"></textarea>

            <label for="birdImage">Upload Image</label>
            <input type="file" id="birdImage" accept="image/*">

            <button type="button" onclick="addPost()">Submit</button>

        </form>

    </div>
</div>

<!-- POSTS -->


<div id="posts" class="section">
    <div class="card">
        <h2>All Observations</h2>
        <input type="text" id="searchBox" placeholder="Search..." onkeyup="searchPosts()">
        
    
        <div id="postList"></div>
    </div>
</div>



<script>

function showSection(id){
    document.querySelectorAll('.section').forEach(sec=>{
        sec.classList.remove('active');
    });
    document.getElementById(id).classList.add('active');
    if(id==="posts") renderPosts();
}

function registerUser(){
    let u=document.getElementById("regUsername").value;
    let p=document.getElementById("regPassword").value;
    if(u===""||p===""){ alert("Fill all fields"); return;}
    localStorage.setItem("user_"+u,p);
    alert("Registered Successfully");
}

function loginUser(){
    let u=document.getElementById("loginUsername").value;
    let p=document.getElementById("loginPassword").value;
    let stored=localStorage.getItem("user_"+u);
    document.getElementById("loginMessage").innerText=
        stored===p?"Login Successful":"Invalid Credentials";
}

function addPost(){
    let post={
        username:username.value,
        location:location.value,
        date:date.value,
        time:time.value,
        bird:bird.value,
        duration:duration.value,
        comments:comments.value
    };

    if(post.username===""||post.date===""){alert("Fill required fields");return;}

    let posts=JSON.parse(localStorage.getItem("posts"))||[];
    posts.push(post);
    localStorage.setItem("posts",JSON.stringify(posts));
    alert("Post Added");
}

function renderPosts(){
    let posts=JSON.parse(localStorage.getItem("posts"))||[];
    let container=document.getElementById("postList");
    container.innerHTML="";

    posts.forEach((p,i)=>{
        container.innerHTML+=`
            <div class="post-card">
                <h3>${p.bird} - ${p.location}</h3>
                <p><strong>User:</strong> ${p.username}</p>
                <p>${p.comments}</p>
                <button class="small-btn" onclick="deletePost(${i})">Delete</button>
            </div>
        `;
    });
}

function deletePost(i){
    let posts=JSON.parse(localStorage.getItem("posts"))||[];
    posts.splice(i,1);
    localStorage.setItem("posts",JSON.stringify(posts));
    renderPosts();
}

function searchPosts(){
    let keyword=searchBox.value.toLowerCase();
    document.querySelectorAll(".post-card").forEach(card=>{
        card.style.display=card.innerText.toLowerCase().includes(keyword)?"block":"none";
    });
}

</script>

</body>
</html>