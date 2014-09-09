

package com.dataart.pages;

import java.util.concurrent.TimeUnit;
import net.thucydides.core.annotations.DefaultUrl;
import net.thucydides.core.annotations.findby.FindBy;
import net.thucydides.core.pages.PageObject;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.interactions.Actions;

/**
 *
 * @author kmartyshchenko
 */
public class DocsPage extends PageObject {
    
        @FindBy(xpath="//a[@href='/docs/regulations']")
	public WebElement regulationsDocsMenuItem;
	
	@FindBy(xpath="//*[@href='/docs/guidance'][contains(text(), 'Guidance')]")
	public WebElement guidanceDocsMenuItem;
	
	@FindBy(xpath="//a[@class='document-title']")
	public WebElement docsTitlesGeneralXpath;
        
        @FindBy (xpath="html/body/div[2]/div/div[5]/div[2]/a[1]")
        public WebElement firstDocLink;
        
        @FindBy(xpath="//li[contains(@class,'dropdown')]/a[@class='dropdown-toggle']")
	public WebElement docsLink;
        
        public final static String REGULATIONS_DOCS_PAGE_TITLE = "Docs - ICPC";
	
	public final static String GUIDANCE_DOCS_PAGE_TITLE = "Guidance Docs - ICPC";
	
	public final static String DOCS_TITLE_GENERAL_XPATH = "//a[@class='document-title']";
        
        public final static String GUIDANCE_DOCS_MENU_XPATH = "//*[@href='/docs/guidance'][contains(text(), 'Guidance')]";
        
        
        
        
        
        
}
