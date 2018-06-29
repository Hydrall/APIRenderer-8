<?php 
/**
 * @file
 * Default theme implementation to format the whole page.
 *
 * Available variables: 
 * - $contentSp: list content for sponsored bills
 * - $contentCo: list content for cosponsored bills
 * - $results: results per page
 * 
 */
?>
<div class="container propublica">
	<div class="row">
		<div class="col-md-4 col-md-push-8" id="filter">
			<select id="selectMe" name="sponsored">
				<option value=""  selected="selected">
					By Sponsorship
				</option>
				<option class="spon" value="1" >
					Sponsored&nbsp;
				</option>
				<option class="cosp" value="2">
					Cosponsored&nbsp;
				</option>
			</select>
			<select id="congressSelectSp" class="sponsored">
			</select>
			<select id="congressSelectCo" class="cosponsored">
			</select>
			<aside id="search-thomas">
				<div id="search-thomas-pod" class="inline-search">
					<h3>
						Search Congress.gov
					</h3>
					<label for="thomas_search">
						<span class="hidden">
							Search Congress
						</span>
					</label>
					<form id="congress" title="Thomas Search" class="form-inline form">
						<input type="hidden" name="congress" id="congress" value="115">
						<input type="hidden" name="database" value="text">
						<input name="MaxDocs" type="hidden" value="1000">
						<div class="row">
							<div class="col-xs-9">
								<input id="thomas_search" name="query" value="" type="text" class="form-control" placeholder="Search">
							</div>
							<div class="col-xs-3">
								<input class="btn btn-block" name="Search" type="submit" id="side-search-btn" value="Go">
							</div>
						</div>
					</form>
				</div>
			</aside>
			<aside class="list ">
				<div id="sam-congressionalrecord" class="amend-textarea">
					<h2>Congress.gov Information</h2>
					<p>
						The leadership of the 104th Congress directed the Library of Congress to make federal legislative information freely available to the public. <a href="http://www.congress.gov">See all Legislation at Congress.gov&nbsp;»</a>
					</p>
				</div>
			</aside>
		</div>
		<div class="col-md-8 col-md-pull-4 sponsorship">
			<table class="sponsored legislationtable" style="display:none;" id="sponsored_table">
				<h2 id="sponsoredHeading" class="sponsored">
					Sponsored Legislation
				</h2>
				<tr>
					<th id="bill-number" class="col-md-3">
						Bill #
					</th>
					<th id="bill-description" class="col-md-6">
						Bill Description
					</th>
					<th id="bill-updated" class="col-md-3" >
						Updated
					</th>
				</tr>
				<?php print $contentSp ?>
			</table>
			<table class="cosponsored legislationtable" id="cosponsored_table" style="display: none;">
				<h2 id="cosponsoredHeading" class="cosponsored" style="display: none;">Cosponsored Legislation</h2>
				<tr>
					<th id="bill-number" class="col-md-3">
						Bill #
					</th>
					<th id="bill-description" class="col-md-6">
						Bill Description
					</th>
					<th id="bill-updated" class="col-md-3" >
						Updated
					</th>
				</tr>
				<?php print $contentCo ?>
			</table>
		</div>
	</div>
	<div class="row">
		<div id="pagination-right">
			<div class="sponsored form-inline" id="pageDivSp">
			</div>
			<div class="cosponsored form-inline" id="pageDivCo">
			</div>
		</div>
	</div>
</div>
<script>
	jQuery(document).ready(function($) {
		window.onload = function(){
			$(".sponsored").show();
			$(".cosponsored").hide();
			//Get default results per page.
			var $results = <?php print $results ?>;
			//Create the pagination.
			makePages('Sp', 'sponsored', $results, '.page');
			makePages('Co', 'cosponsored', $results, '.page');
			//Create the Congress Select options.
			var $congressesSp = [];
			var $congressesCo = [];
			//Loop through pages, checking the congress number. If it's not in the congresses array, add it.
			$(".pageSp").each(function ($index, $value) {
				var $classes = $(this)[0].classList;
				for (var $x = 0; $x < $classes.length; $x++) {
					if ($classes[$x].match("^congress")) {
						var $letters = $classes[$x].split("");
						var $number = parseInt($letters[8] + $letters[9] + $letters[10]);
						if ($.inArray($number, $congressesSp) == -1) {
							$congressesSp.push($number);
						}
					}
				}
			});
			$(".pageCo").each(function ($index, $value) {
				var $classes = $(this)[0].classList;
				for (var $x = 0; $x < $classes.length; $x++) {
					if ($classes[$x].match("^congress")) {
						var $letters = $classes[$x].split("");
						var $number = parseInt($letters[8] + $letters[9] + $letters[10]);
						if ($.inArray($number, $congressesCo) == -1) {
							$congressesCo.push($number);
						}
					}
				}
			});
			//Now that we have a list of present Congresses, we can make the select!
			var $optionCongressesSp = '<option value="all">By Congress</option>';
			for (var $x = 0; $x < $congressesSp.length; $x++) {
				$optionCongressesSp += ('<option value="' + $congressesSp[$x] + '">Congress ' + $congressesSp[$x] + '</option>');
			}
			jQuery("#congressSelectSp").append($optionCongressesSp);
			var $optionCongressesCo = '<option value="all">By Congress</option>';
			for (var $x = 0; $x < $congressesCo.length; $x++) {
				$optionCongressesCo += ('<option value="' + $congressesCo[$x] + '">Congress ' + $congressesCo[$x] + '</option>');
			}
			jQuery("#congressSelectCo").append($optionCongressesCo);
		}
		/* DETECT SPONSORED/COSPONSORED SELECTION */
		$('#selectMe').on('change', function() {
			if ( this.value == '1')
			{
				$(".sponsored").show();
				$(".cosponsored").hide();
			}
			else if (this.value == '2')
			{
				$(".sponsored").hide();
				$(".cosponsored").show();
			}
			else 
			{
				$(".sponsored").show();
				$(".cosponsored").hide();
			}
		});
		/* SEARCH BAR */
		$("#side-search-btn").click(function(){
			var q;
			var c;
			c=$("#congress").val();
			q=$("#thomas_search").val();
			window.open(
				"https://www.congress.gov/search?q=%7B%22source%22%3A%22legislation%22%2C%22congress%22%3A%22"+c+"%22%2C%22search%22%3A%22"+q+"%22%7D",
				"_newtab"
			);
		});
		$('#form_thomas_search').submit(function(){
			var q;
			var c;
			c=$("#congress").val();
			q=$("#thomas_search").val();
			window.open(
				"https://www.congress.gov/search?q=%7B%22source%22%3A%22legislation%22%2C%22congress%22%3A%22"+c+"%22%2C%22search%22%3A%22"+q+"%22%7D",
				"_newtab"
			);
			event.preventDefault();
		});
		/* SWITCH PAGES */
		$(document).on('change', '.pageSelect', function() {
			if ($(this).hasClass("sponsored")) {
				var $newPage = '.pageNumSp' + $(this).find('option:selected').val();
				$('.pageSp').hide();
				$('.unpaged').hide();
				$($newPage).show();
			}
			else {
				var $newPage = '.pageNumCo' + $(this).find('option:selected').val();
				$('.pageCo').hide();
				$('.unpaged').hide();
				$($newPage).show();
			}
		});
		/* SWITCH CONGRESS */
		$('#congressSelectSp').on('change', function() {
			if ($(this).find('option:selected').val() == 'all') {
				var $results = <?php print \Drupal::config('apirenderer.settings')->get("apirenderer_propublica_default_results") ?>;
				makePages('Sp', 'sponsored', $results, '.page');
			}
			else {
				var $newCongress = '.congress' + $(this).find('option:selected').val();
				var $results = <?php print \Drupal::config('apirenderer.settings')->get("apirenderer_propublica_default_results") ?>;
				makePages('Sp', 'sponsored', $results, $newCongress);
			}
			if ($('#selectMe').find('option:selected').val() == '1') {
				$(".sponsored").show();
				$(".cosponsored").hide();
			}
			else if ($('#selectMe').find('option:selected').val() == '2') {
				$(".sponsored").hide();
				$(".cosponsored").show();
			}
			else {
				$(".sponsored").show();
				$(".cosponsored").hide();
			}
		});
		$('#congressSelectCo').on('change', function() {
			if ($(this).find('option:selected').val() == 'all') {
				var $results = <?php print \Drupal::config('apirenderer.settings')->get("apirenderer_propublica_default_results") ?>;
				makePages('Co', 'cosponsored', $results, '.page');
			}
			else {
				var $newCongress = '.congress' + $(this).find('option:selected').val();
				var $results = <?php print \Drupal::config('apirenderer.settings')->get("apirenderer_propublica_default_results") ?>;
				makePages('Co', 'cosponsored', $results, $newCongress);
			}
			if ($('#selectMe').find('option:selected').val() == '1') {
				$(".sponsored").show();
				$(".cosponsored").hide();
			}
			else if ($('#selectMe').find('option:selected').val() == '2') {
				$(".sponsored").hide();
				$(".cosponsored").show();
			}
			else {
				$(".sponsored").show();
				$(".cosponsored").hide();
			}
		});
		function makePages($table, $tableLong, $results, $loop) {
			//Remove existing pages, if any. Uses a regular expression to find what pages there were, then removes them.
			var $pagesFound = [];
			$(".paged.page" + $table).each(function($index, $value) {
				var $classes = $(this)[0].classList;
				for (var $x = 0; $x < $classes.length; $x++) {
					if ($classes[$x].match("^pageNum")) {
						if ($.inArray($classes[$x], $pagesFound) == -1) {
							$pagesFound.push($classes[$x]);
						}
					}
				}
			});
			for (var $x = 0; $x < $pagesFound.length; $x++) {
				$('.' + $pagesFound[$x]).removeClass($pagesFound[$x]);
			}
			$(".paged.page" + $table).removeClass("paged");
			$(".unpaged.page" + $table).removeClass("unpaged");
			$("#pageDiv" + $table).empty();
			//Split up each section based on results per page. Iterates through each page of each table and divides them up based on the number of results set.
			var $page = 1;
			$(($loop + $table)).each(function($index, $value) {
				if ((($index + 1) % $results == 0) && ($index !== ($(($loop + $table)).length - 1))) {
					$(this).addClass("pageNum" + $table + $page);
					$(this).addClass("paged");
					$page++;
				}
				else {
					$(this).addClass("pageNum" + $table + $page);
					$(this).addClass("paged");
				}
			});
			$('.page' + $table).each(function($index, $value) {
				if (!($(this).hasClass("paged"))) {
					$(this).addClass("unpaged");
				}
			});
			//Create the pagination.
			var $option = 'Showing page <select class="span4 pageSelect ' + $tableLong + '" name="pageSelect" id="pageSelect' + $tableLong + '" title="Select Page">';
			for (var $i = 0; $i < $page; $i++) {
				if ($i == 0) {
					$option += ('<option value="' + ($i + 1) + '" selected="selected">' + ($i + 1) + '</option>');
				}
				else {
					$option += ('<option value="' + ($i + 1) + '">' + ($i + 1) + '</option>');
				}
			}
			$option += ('</select>&nbsp;of&nbsp;' + $page + '</div>');
			jQuery("#pageDiv" + $table).append($option);
			$(".result").hide();
			$(".unpaged").hide();
			$(".pageNumSp1").show();
			$(".pageNumCo1").show();
		}
	});
</script>