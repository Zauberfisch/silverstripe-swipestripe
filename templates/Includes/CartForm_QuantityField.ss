<tr>
	<td class="remove">
		<a href="#" data-item="$Item.ID" class="remove-item-js"></a>
	</td>
	<td class="title">
		<% if $Item.Product.isPublished %>
			<a href="$Item.Product.Link" target="_blank">$Item.Product.Title</a>
		<% else %>
			$Item.Product.Title
		<% end_if %>
		<% if $Item.SummaryOfOptions %>
			<div class="summary-of-options">
				$Item.SummaryOfOptions
			</div>
		<% end_if %>
		<% if $Message %>
			<div class="message $MessageType">
				$Message
			</div>
		<% end_if %>
	</td>
	<td class="item-price">
		$Item.UnitPrice.Nice
	</td>
	<td class="quantity">
		<div id="$Name" class="field $Type $extraClass">
			$titleBlock
			<div class="middleColumn">$Field</div>
			$rightTitleBlock
		</div>
	</td>
	<td class="item-total-price">
		$Item.TotalPrice.Nice
	</td>
</tr>
