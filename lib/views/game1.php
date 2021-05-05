<p><?php echo $message ?></p>
<style>
	#game {
   text-align:center;
}
	canvas{
	display: inline;
	margin-top:-100px;
	margin-left:auto;
	margin-right:auto;
    padding:0;
	}
	h2{
		margin-top:-20px;

	}
	p{
		margin-bottom:15px;

	}
</style>
<h2>Recycling Game</h2>
<p>Instructions: Drag the paper to shoot the paper into the bin!<p>


<script type="text/javascript" src="../lib/views/games/js/phaser.min.js"></script>
<div id="game">
<script type="text/javascript" src="../lib/views/games/js/game.js"></script>
</div>