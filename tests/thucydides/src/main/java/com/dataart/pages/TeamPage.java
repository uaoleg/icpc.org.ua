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
	
}
