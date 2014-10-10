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
	public WebElementFacade exportForCheckingSystemItem;
        @FindBy(xpath="//a[@href='/team/exportRegistration']")
	public WebElementFacade exportForRegistrationItem;
        @FindBy(xpath="//button[@class='btn btn-primary btn-lg btn-save'][@type='submit']")
	public WebElementFacade saveTeamButton;
        @FindBy(xpath="//input[@id='s2id_autogen1']")
	public WebElementFacade addStudentsField;
        @FindBy(xpath="html/body/div[5]/ul/li[1]/div")
	public WebElementFacade firstStudentOption;
        @FindBy(xpath="html/body/div[5]/ul/li[2]/div")
	public WebElementFacade secondStudentOption;
        @FindBy(xpath="html/body/div[5]/ul/li[3]/div")
	public WebElementFacade thirdStudentOption;
        @FindBy(xpath="//a[contains(text(), 'YNCtestteam')]")
	public WebElementFacade teamNameinTable;
        @FindBy(xpath="//button[@class='btn btn-danger btn-delete-team']")
	public WebElementFacade deleteTeamButton;
        @FindBy(xpath="//button[@class='btn btn-default dropdown-toggle']")
	public WebElementFacade downloadTeamlistDropdown;
        @FindBy(xpath="//input[@id='gs_name']")
	public WebElementFacade teamNameSortTextfield;
        @FindBy(xpath="//input[starts-with(@id, 'gs_schoolName')]")
	public WebElementFacade universityNameSortTextfield;
        
        

        
        public final static String TEAMS_PAGE_TITLE = "Team - ICPC";
        public final static String TEAMS_PROFILE_PAGE_TITLE = "View Team - ICPC";
        public final static String USER_PROFILE_PAGE_TITLE = "View User - ICPC";
        public final static String Team_Name = teamNameGenerator();
        //public final static String TEAM_NAME_IN_TABLE = "//td[@title='YNC" + Team_Name +"']";
        public final static String TEAM_NAME_IN_TABLE = "//a[contains(text(), 'YNCtestteam')]";
        public final static String TEAM_NAME_IN_TABLE_GENERAL_XPATH = "//td[@aria-describedby='team-list_name']/a";
        public final static String COACH_NAME_IN_TABLE_GENERAL_XPATH = "//td[@aria-describedby='team-list_coachNameEn']/a";
        public final static String STUDENTS_NAME_IN_TABLE_GENERAL_XPATH = "//td[@aria-describedby='team-list_members']/a";
        public final static String UNIVERSITY_NAME_IN_TABLE_GENERAL_XPATH = "//td[starts-with(@aria-describedby, 'team-list_schoolName')]";
        
        
        public static String teamNameGenerator(){            
             String teamName = "testteam" + (int) (Math.random()*1000 + 1);
             return teamName;
        }
        
	
}
