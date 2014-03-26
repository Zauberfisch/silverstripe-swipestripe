<% if $IncludeFormTag %>
<form $FormAttributes>
<% end_if %>

	<% if $Message %>
		<p id="{$FormName}_error" class="message $MessageType">$Message</p>
	<% else %>
		<p id="{$FormName}_error" class="message $MessageType" style="display: none"></p>
	<% end_if %>
	
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th class="remove">&nbsp;</th>
				<th class="title"><%t CartForm.PRODUCT 'Product' %></th>
				<th class="item-price"><%t CartForm.PRICE 'Price ({currency})' currency=$Cart.TotalPrice.Currency %></th>
				<th class="quantity"><%t CartForm.QUANTITY 'Quantity' %></th>
				<th class="item-total-price"><%t CartForm.TOTAL 'Total ({currency})' currency=$Cart.TotalPrice.Currency %></th>
			</tr>
		</thead>
		<tbody>
			
			<% if $Cart.Items %>
			
				<% loop $Fields %>
					$FieldHolder
				<% end_loop %>
				
				<% with $Cart %>
				<tr class="total-price">
					<td colspan="4"><%t CartForm.ALLTOTAL '&nbsp;' %></td>
					<td><strong>$CartTotalPrice.Nice</strong></td>
				</tr>
				<% end_with %>
			
			<% else %>
				<tr>

					<td colspan="6">
						<p class="alert alert-info">
							<strong class="alert-heading"><%t CartForm.NOTE 'Note:' %></strong>
							<%t CartForm.NO_ITEMS_IN_CART 'There are no items in your cart.' %>
						</p>
					</td>

				</tr>
			<% end_if %>

		</tbody>
	</table>

	<div class="Actions">
		<p class="attribution">
			<%t CartForm.POWERED_BY 'powered by' %> <a target="_blank" href="http://swipestripe.com">SwipeStripe Ecommerce</a>
		</p>
		 
		<% if $Cart.Items %>
			<% if $Actions %>

				<% loop $Actions %>
					$Field
				<% end_loop %>
			
			<% end_if %>
		<% end_if %>
	</div>
	
<% if $IncludeFormTag %>
</form>
<% end_if %>