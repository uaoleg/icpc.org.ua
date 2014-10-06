package com.dataart.pages;

import java.util.List;

import net.thucydides.core.annotations.findby.FindBy;
import net.thucydides.core.pages.PageObject;
import net.thucydides.core.pages.WebElementFacade;

import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;

public class ManageUserPage extends PageObject {

	@FindBy(xpath = "//li[contains(@class,'dropdown')]/a[@class='dropdown-toggle']")
	public List<WebElement> usersLink;

	@FindBy(xpath = "//*[@href='/staff/coaches']")
	public WebElement coaches;

	@FindBy(id = "staff__coaches_list")
	public WebElement userTable;
	
	@FindBy(css=".label.col-md-4.col-md-offset-4.label-success")
	public WebElement approvedStatus;
	
	@FindBy(css=".label.col-md-4.col-md-offset-4.label-warning")
	public WebElement notapprovedStatus;
	@FindBy(id="gs_email")
	public WebElementFacade emailSearchField;
	@FindBy(xpath ="//td[@aria-describedby='staff__coaches_list_email']")
	public WebElement emailCell;

	// The code below is a sample how to use html table in thucydides!
	/*
	 * public String getTableRows(){
	 * 
	 * List<Map<Object, String>> tableRows =
	 * HtmlTable.withColumns("Name","Email",
	 * "Registration date","Status").readRowsFrom(userTable);
	 * System.out.println(tableRows.get(0).); return null;
	 * 
	 * }
	 * 
	 * @Test public void should_read_table_data_for_a_table_with_no_heading() {
	 * List<Map<Object, String>> tableRows =
	 * HtmlTable.withColumns("First Name","Last Name", "Favorite Colour")
	 * .readRowsFrom(page.clients_with_no_headings);
	 * 
	 * assertThat(tableRows.size(), is(3)); assertThat(tableRows.get(0),
	 * allOf(hasEntry("First Name", "Tim"), hasEntry("Last Name",
	 * "Brooke-Taylor"), hasEntry("Favorite Colour", "Red")));
	 * assertThat(tableRows.get(1), allOf(hasEntry("First Name", "Graeme"),
	 * hasEntry("Last Name", "Garden"), hasEntry("Favorite Colour", "Green")));
	 * assertThat(tableRows.get(2), allOf(hasEntry("First Name",
	 * "Bill"),hasEntry("Last Name", "Oddie"),
	 * hasEntry("Favorite Colour","Blue"))); }
	 * 
	 * @Test public void
	 * should_manipulate_table_data_for_a_table_with_no_heading() { boolean
	 * containsRowElements = HtmlTable.withColumns("First Name","Last Name",
	 * "Favorite Colour")
	 * .inTable(page.clients_with_no_headings).containsRowElementsWhere
	 * (the("First Name", is("Tim")), the("Last Name",
	 * containsString("Taylor")));
	 * 
	 * assertThat(containsRowElements, is(true)); }
	 */
	public void click_on_ActivateStatusSample(String email) {
		List<WebElement> rows = getDriver().findElements(
				By.xpath("//table[@id='staff__coaches_list']/tbody/tr"));
		for (WebElement row : rows) {
			String emailField = row.findElement(
					By.xpath("//tbody/tr/td[@title='" + email + "']"))
					.getText();
			if (emailField.equals(email)) {
				row.findElement(By.xpath("//td[4]//button[1]")).click();
			}
		}
	}

	public void click_on_ActivateStatus(String email) {

		List<WebElement> emailFieldList = getDriver().findElements(
				By.xpath("//td[2]"));

		for (WebElement col : emailFieldList)

			if (col.getText().equals(email)) {
				col.findElement(By.xpath("//td[4]//button[1]")).click();
				break;
			}

	}
}
