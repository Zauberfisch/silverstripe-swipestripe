<tr>
	<td class="product-column">
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
			<div class="message $MessageType">$Message</div>
		<% end_if %>
	</td>
	<td class="price-column">$Item.UnitPrice.Nice</td>
	<td class="quantity-column">$Item.Quantity</td>
	<td class="totals-column">$Item.TotalPrice.Nice</td>
</tr>