package com.dataart.steps;

import com.dataart.pages.DocsPage;
import com.dataart.pages.LoginPage;
import java.awt.AWTException;
import java.awt.Robot;
import java.awt.Toolkit;
import java.awt.datatransfer.StringSelection;
import java.awt.event.KeyEvent;
import java.io.DataOutputStream;
import java.io.IOException;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.Properties;
import java.util.Set;
import java.util.concurrent.TimeUnit;
import java.util.logging.Level;
import java.util.logging.Logger;
import junit.framework.Assert;
import net.thucydides.core.annotations.Step;
import net.thucydides.core.steps.ScenarioSteps;
import org.openqa.selenium.By;
import org.openqa.selenium.JavascriptExecutor;

import org.openqa.selenium.Keys;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.interactions.Actions;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;
import static org.yecht.MapPart.Key;

/**
 * 
 * @author kmartyshchenko
 */
public class UserDocsSteps extends ScenarioSteps {
	DocsPage docsPage;

	@Step
	public void click_Docs_and_choose_Regulations() {
		Actions builder = new Actions(getDriver());
		builder.moveToElement(docsPage.docsLink).click().perform();
		waitABit(1000);
		docsPage.element(docsPage.docsLink).waitUntilVisible();
		waitABit(1000);
		builder.moveToElement(docsPage.regulationsDocsMenuItem).click()
				.perform();
	}

	@Step
	public void click_Docs_and_choose_Guidance() {
		Actions builder = new Actions(getDriver());
		builder.moveToElement(docsPage.docsLink).click().perform();
		waitABit(1000);
		docsPage.element(docsPage.docsLink).waitUntilVisible();
		waitABit(1000);
		builder.moveToElement(docsPage.guidanceDocsMenuItem).click().perform();
	}

	@Step
	public void is_on_the_Regulation_Page() {
		docsPage.waitForTitleToAppear(DocsPage.REGULATIONS_DOCS_PAGE_TITLE);
	}

	@Step
	public void is_on_the_Guidance_Page() {
		docsPage.waitForTitleToAppear(DocsPage.GUIDANCE_DOCS_PAGE_TITLE);
	}

	@Step
	public void first_doc_link_click() throws AWTException {
		/*
		 * Properties properties = System.getProperties(); Set<Object>
		 * sysPropertiesKeys = properties.keySet(); for (Object key :
		 * sysPropertiesKeys) { // System.out.println(key + " =" +
		 * properties.getProperty((String)key));
		 * if(properties.getProperty((String)key).equals("iexplorer")){
		 * System.out.println("Close"); getDriver().quit();
		 * 
		 * } }
		 * 
		 * docsPage.firstDocLink.click();
		 */

	}

	@Step
	public int is_doc_avaible_by_URL() throws MalformedURLException,
			IOException {
		// String USER_AGENT = "Mozilla/5.0";
		// URL u = new URL(el.getAttribute("href"));
		// System.out.println(u);
		// HttpURLConnection huc = (HttpURLConnection) u.openConnection();
		// huc.setRequestMethod("GET");
		// huc.setRequestProperty("User-Agent", USER_AGENT);
		// huc.setRequestProperty("Accept-Language", "en-US,en;q=0.5");
		// huc.setDoOutput(true);
		// DataOutputStream wr = new DataOutputStream(huc.getOutputStream());
		// wr.flush();
		// wr.close();
		//
		// int responseCode = huc.getResponseCode();
		// System.out.println("\nSending 'GET' request to URL : " + u);
		// // System.out.println("Post parameters : " + urlParameters);
		// System.out.println("Response Code : " + responseCode);
		// return responseCode;
		URL u = new URL(docsPage.firstDocLink.getAttribute("href"));
		HttpURLConnection huc = (HttpURLConnection) u.openConnection();
		huc.setRequestMethod("GET");
		huc.setRequestProperty("User-Agent", "Mozilla/5.0");
		huc.setRequestProperty("Accept-Language", "en-US,en;q=0.5");
		huc.connect();
		System.out.println(huc.getResponseCode());
		return huc.getResponseCode();

	}

	@Step
	public void upload_regulation_doc_button_click() {
		docsPage.uploadRegulationDocButton.click();
		waitABit(1000);
	}

	@Step
	public void upload_guidance_doc_button_click() {
		docsPage.uploadGuidanceDocButton.click();
		waitABit(1000);
	}

	@Step
	public void fills_all_the_fields() {
		docsPage.titleInputField.sendKeys("testtitle");
		docsPage.descriptionInputField.sendKeys("testdescription");
                //waitABit(1000);
		docsPage.chooseFileButton.click();
		waitABit(1000);

	}

	@Step
	public void upload_file_and_click_Save_Document_button()
			throws AWTException {
		// WebElement elem =
		// getDriver().findElement(By.xpath("//input[@id='html5_19135rc2bkee11h810v91mhv1tl23'][@type='file']"));
		// String js =
		// "arguments[0].style.height='auto'; arguments[0].style.overflow='visible';";
		// ((JavascriptExecutor) getDriver()).executeScript(js, elem);
		// docsPage.uploadDocButton.sendKeys("c:\TestDoc.doc");
		// WebDriverWait waiting = new WebDriverWait(getDriver(), 30, 1000);
		// waiting.until(ExpectedConditions.visibilityOfElementLocated(By.xpath(DocsPage.SAVE_DOCUMENT_BUTTON_XPATH)));
		StringSelection ss = new StringSelection("C:\\TestDoc.doc");
		Toolkit.getDefaultToolkit().getSystemClipboard().setContents(ss, null);
		Robot robot = new Robot();
		 //robot.keyPress(KeyEvent.VK_ENTER);
		// robot.keyRelease(KeyEvent.VK_ENTER);
		robot.keyPress(KeyEvent.VK_CONTROL);
		robot.keyPress(KeyEvent.VK_V);
                waitABit(5000);
		robot.keyRelease(KeyEvent.VK_CONTROL);
		robot.keyRelease(KeyEvent.VK_V);
                waitABit(5000);
		robot.keyPress(KeyEvent.VK_ENTER);
		robot.keyRelease(KeyEvent.VK_ENTER);
                waitABit(5000);
               // getDriver().manage().timeouts().implicitlyWait(10, TimeUnit.SECONDS);
                WebDriverWait waiting = new WebDriverWait(getDriver(), 30, 1000);
                waiting.until(ExpectedConditions.presenceOfElementLocated(By.xpath(DocsPage.SAVE_DOCUMENT_BUTTON_XPATH)));


		docsPage.saveDocumentButton.click();
                waitABit(5000);

	}

	@Step
	public void is_document_in_the_list() {
		Assert.assertEquals(
				"testtitle",
				getDriver().findElement(
						By.xpath(DocsPage.FIRST_DOCUMENT_LINK_XPATH)).getText());
	}

	@Step
	public void delete_first_doc_button_click() {
		docsPage.deleteFirstDocButton.click();
	}

	@Step
	public void cofirm_deleting_of_the_doc() {
		try {
			Robot robot = new Robot();
			robot.keyPress(KeyEvent.VK_ENTER);
			robot.keyRelease(KeyEvent.VK_ENTER);
			waitABit(500);
			robot.keyPress(KeyEvent.VK_F5);
			robot.keyRelease(KeyEvent.VK_F5);
		} catch (AWTException ex) {
			Logger.getLogger(UserDocsSteps.class.getName()).log(Level.SEVERE,
					null, ex);
		}
	}

	@Step
	public void is_document_not_in_the_list() {
		String s = getDriver().findElement(
				By.xpath(DocsPage.FIRST_DOCUMENT_LINK_XPATH)).getText();
		Assert.assertNotSame(s, "testtitle");
	}

	@Step
	public void edit_first_doc_button_click() {
		docsPage.editFirstDocButton.click();
	}

	@Step
	public void fills_all_the_fields_with_new_information() {
		docsPage.titleInputField.clear();
		docsPage.descriptionInputField.clear();
		docsPage.titleInputField.sendKeys("testtitle");
		docsPage.descriptionInputField.sendKeys("testdescription");
		waitABit(3000);

	}

	@Step
	public void click_Docs_and_choose_Guidance_in_Edit_Menu() {
		Actions builder = new Actions(getDriver());
		builder.moveToElement(docsPage.editMenuDocTypeDropdown).build()
				.perform();
		docsPage.element(docsPage.editMenuDocTypeDropdown).waitUntilVisible();
		waitABit(500);
		builder.moveToElement(docsPage.editMenuDocTypeGuidanceItem).click()
				.perform();
	}

	@Step
	public void click_Docs_and_choose_Regulations_in_Edit_Menu() {
		Actions builder = new Actions(getDriver());
		builder.moveToElement(docsPage.editMenuDocTypeDropdown).build()
				.perform();
		waitABit(1000);
		docsPage.element(docsPage.editMenuDocTypeDropdown).waitUntilVisible();
		waitABit(500);
		builder.moveToElement(docsPage.editMenuDocTypeRegulationsItem).click()
				.perform();
	}

	@Step
	public void click_Save_Document_Button() {
		docsPage.saveDocumentButton.click();
	}

	@Step
	public void find_Editted_Doc_in_the_LIST() {
		getDriver().findElement(
				By.xpath(DocsPage.DOC_WITH_PRESET_DESCRIPTION_XPATH))
				.isDisplayed();
	}

}
