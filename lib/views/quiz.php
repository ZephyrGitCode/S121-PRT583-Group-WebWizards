
<style>
  h2, h3, #test_status, #completion{
    text-align: center;
    padding:10px;
  }
  h2{
    margin-top:-20px;
  }
#green{
  width:20%;
}
.mainimg3{
text-align:center;
width: 330px;
height:250px;
}

#test{
  text align:center;
  display:grid;
  grid-template-columns:auto auto auto;
}
#test img{
width:100px;
padding:10px;
}

    </style>


    <h2 id="test_status"></h2>
    <div id="test"></div>
    <div id="completion"></div>

<script>
var pos = 0, test, test_status, question, choice, choices, chA, chB, chC, chD, chE, chF, correct = 0;
// this is a multidimensional array with 4 inner array elements with 5 elements inside them
var questions = [
  {
      question: "../lib/views/images/coke.jpg",
      a: "Recycle",
      b:"../lib/views/images/green2.png",
      c: "General",
      d:"../lib/views/images/red.png",
      e: "Comingled",
      f:"../lib/views/images/yellow.png",
      answer: "A"
    },
  {
      question: "../lib/views/images/bannana.jpg",
      a: "Recycle",
      b:"../lib/views/images/green2.png",
      c: "General",
      d:"../lib/views/images/red.png",
      e: "Comingled",
      f:"../lib/views/images/yellow.png",
      answer: "B"
    },
  {
      question: "../lib/views/images/battery.jpg",
      a: "Recycle",
      b:"../lib/views/images/green2.png",
      c: "General",
      d:"../lib/views/images/red.png",
      e: "Comingled",
      f:"../lib/views/images/yellow.png",
      answer: "C"
    },
  {
      question: "../lib/views/images/cardboard.jpg",
      a: "Recycle",
      b:"../lib/views/images/green2.png",
      c: "General",
      d:"../lib/views/images/red.png",
      e: "Comingled",
      f:"../lib/views/images/yellow.png",
      answer: "A"
    }
  ];
// this get function is short for the getElementById function  
function get(x){
  return document.getElementById(x);
}
// this function renders a question for display on the page
function renderQuestion(){
  test = get("test");
  if(pos >= questions.length){
    test.innerHTML = "<h3>You got "+correct+" of "+questions.length+" questions correct</h3>";
    get("test_status").innerHTML = "</h2>Test completed</h2>";
    if(correct < questions.length){
      get("completion").innerHTML ="<p>You earned "+correct+" points </br> Have a look at the Waste classfication to improve your knowledge on waste disposal</p><form action='/quiz' method='POST'><input type='hidden' name='_method' value='put' /><input type='hidden' name='quiz' value="+correct+"><input type='submit' value='Click to add points to leaderboard'></form>"
    }else{
      get("completion").innerHTML ="<p>You earned "+correct+" points</p><form action='/quiz' method='POST'><input type='hidden' name='_method' value='put' /><input type='hidden' name='quiz' value="+correct+"><input type='submit' value='Click to add points to leaderboard'></form>"
    }
    // resets the variable to allow users to restart the test
    pos = 0;
    correct = 0;
    // stops rest of renderQuestion function running when test is completed
    return false;
  }
  get("test_status").innerHTML = "Examine the photo and click the correct waste category</br><h3>Question "+(pos+1)+" of "+questions.length+"</h3>";
  
  question = questions[pos].question;
  chA = questions[pos].a;
  chB = questions[pos].b;
  chC = questions[pos].c;
  chD = questions[pos].d;
  chE = questions[pos].e;
  chF = questions[pos].f;
  // display the question
  get("test_status").innerHTML += "<img class='mainimg3'  src="+question+">";
  // display the answer options
  // the += appends to the data we started on the line above
  test.innerHTML = "<label><input id='toggle' type='radio' name='choices' value='A'>&nbsp&nbsp<img src="+chB+ " id ='green' name='choices' value='A'/>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"+chA+"</label>";
  test.innerHTML += "<label><input id='toggle' type='radio' name='choices' value='B'>&nbsp&nbsp<img src="+chD+ " id ='green' name='choices' value='B'/>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"+chC+"</label>";
  test.innerHTML += "<label><input id='toggle' type='radio' name='choices' value='C'>&nbsp&nbsp<img src="+chF+ " id ='green' name='choices' value='C'/>&nbsp&nbsp"+chE+"</label>";
  test.innerHTML += "<button style='color:black' onclick='checkAnswer()'>Submit Answer</button>";
}
function checkAnswer(){
  // use getElementsByName because we have an array which it will loop through
  choices = document.getElementsByName("choices");
  for(var i=0; i<choices.length; i++){
    if(choices[i].checked){
      choice = choices[i].value;
    }
  }
  // checks if answer matches the correct choice
  if(choice == questions[pos].answer){
    //each time there is a correct answer this value increases
    correct++;
  }
  // changes position of which character user is on
  pos++;
  // then the renderQuestion function runs again to go to next question
  renderQuestion();
}
// Add event listener to call renderQuestion on page load event
window.addEventListener("load", renderQuestion);

</script>
