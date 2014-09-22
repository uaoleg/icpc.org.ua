package com.dataart.pages;

import net.thucydides.core.annotations.At;
import net.thucydides.core.annotations.DefaultUrl;
import net.thucydides.core.annotations.findby.FindBy;
import net.thucydides.core.pages.PageObject;
import net.thucydides.core.pages.WebElementFacade;

@DefaultUrl("http://acc.icpc.org.ua/team/list")
@At("http://acc.icpc.org.ua/team/list")
public class TeamPage  extends PageObject{

	@FindBy(xpath="//*[@id='main']//a[@href='/staff/team/manage']")
	public WebElementFacade createTeamButton;
	@FindBy(id="name")
	public WebElementFacade teamNameField;
        @FindBy(xpath="//button[@class='btn btn-default dropdown-toggle']")
	public WebElementFacade exportDropdownList;
        @FindBy(xpath="//a[@href='/team/exportCheckingSystem']")
	public WebElementFacade exportForTrackingSystemItem;
        @FindBy(xpath="//a[@href='/team/exportRegistration']")
	public WebElementFacade exportForRegistrationItem;
        @FindBy(xpath="//button[@class='btn btn-primary btn-lg btn-save'][@type='submit']")
	public WebElementFacade saveTeamButton;
        @FindBy(xpath="//*[@class='select2-choices']")
	public WebElementFacade addStudentsField;
        @FindBy(xpath="html/body/div[5]/ul/li[1]/div")
	public WebElementFacade firstStudentOption;
        @FindBy(xpath="html/body/div[5]/ul/li[2]/div")
	public WebElementFacade secondStudentOption;
        @FindBy(xpath="html/body/div[5]/ul/li[3]/div")
	public WebElementFacade thirdStudentOption;

        
        public final static String TEAMS_PAGE_TITLE = "Team - ICPC";
	
}
