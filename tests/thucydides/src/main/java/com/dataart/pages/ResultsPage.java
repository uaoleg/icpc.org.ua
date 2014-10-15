package com.dataart.pages;

import java.util.List;

import org.openqa.selenium.WebElement;

import net.thucydides.core.annotations.At;
import net.thucydides.core.annotations.DefaultUrl;
import net.thucydides.core.annotations.findby.FindBy;
import net.thucydides.core.pages.PageObject;
import net.thucydides.core.pages.WebElementFacade;

@DefaultUrl("//http://acc.icpc.org.ua/results")
@At("http://acc.icpc.org.ua/results")
public class ResultsPage extends PageObject {

	@FindBy(xpath = ".//*[@id='main']//li/a[contains(@href,'/results')]")
	public WebElementFacade teamsMenu;
	@FindBy(id="pickfiles-modal")
	public WebElementFacade uploadResultsBtn;
	@FindBy(id="uploadPickfiles")
	public WebElementFacade chooseFileBtn;
	
	//@FindBy(xpath="//*[@id='uploadContainer']//input[@value='ukraine']")
	//public WebElement ukraine;
	//@FindBy(xpath="//*[@id='uploadContainer']//input[@value='center']")
	//public WebElement center;
	@FindBy(xpath="//label[contains(@class,'btn-default')]")
	public List<WebElement> areaList;
	@FindBy(css=".close")
	public WebElement closeDialog;
	@FindBy(id="uploadResults")
	public WebElement uploadBtn;
	@FindBy(xpath="//button[@disabled='']")
	public WebElement disabledUpload;
	@FindBy(id="uploadResults")
	public WebElement enableUpload;
	@FindBy(id="gbox_results")
	public WebElement resultTable;
	@FindBy(xpath="//*[@id='uploadModal']/div[@class='modal-dialog']")
	public WebElement modalWindow;
	
}
