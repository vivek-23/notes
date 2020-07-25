// The puzzle is here => http://www.primefactorisation.com/frogpuzzle/

var data = ['b','b','b','b',' ','r','r','r','r'];

function getSteps(data){
  if(isFinished(data)) return true;
  var moves = getLegalMoves(data);
  //console.log(moves,data);
  for(var i=0;i<moves.length;++i){
    swap(moves[i][0],moves[i][1],data);
    if(getSteps(data.slice())){
        console.log("Move " + (moves[i][0] + 1) + " to " + (moves[i][1] + 1));
        return true;   
    }
    swap(moves[i][0],moves[i][1],data); // restoring
  }
  return false;
}

function swap(x,y,data){
    var temp = data[x];
    data[x] = data[y];
    data[y] = temp;
}

function isFinished(data){
    for(var i=1;i<data.length;++i){
       if(data[i] == ' '){
           if(i != parseInt(data.length / 2)) return false;
           i++;
           continue;
       }
       if(data[i] != data[i-1]) return false;
    }
    return data[0] == 'r';
}

function getLegalMoves(data){
  var moves = [];
  for(var i=0;i<data.length;++i){
    if(data[i] == 'r'){
        if(i - 1 >= 0 && data[i-1] == ' '){
          moves.push([i,i-1]);
        }else if(i-2 >= 0 && data[i-2] == ' '){
             moves.push([i,i-2]);
        }
    }else if(data[i] == 'b'){
        if(i + 1 < data.length && data[i+1] == ' '){
          moves.push([i,i+1]);
        }else if(i+2 < data.length && data[i+2] == ' '){
          moves.push([i,i+2]);
        }
    }
  } 
  
  return moves;
}


getSteps(data);
