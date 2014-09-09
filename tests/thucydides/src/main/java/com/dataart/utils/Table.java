package com.dataart.utils;

import java.util.List;

import net.thucydides.core.annotations.findby.By;

import org.openqa.selenium.WebElement;

public class Table {
	// get all rows from the table
	public static int getRowsNumber(WebElement el) {
		WebElement simpleTable = el;
		List<WebElement> rows = simpleTable.findElements(By.tagName("tr"));
		return rows.size();

	}

	public static boolean isTagNameExistInTable(WebElement el,String name ) {
		WebElement simpleTable = el;
		List<WebElement> rows = simpleTable.findElements(By.tagName("tr"));
		// Print data from each row
		for (WebElement row : rows) {
			List<WebElement> cols = row.findElements(By.tagName("td"));
			
			for (WebElement col : cols) {
				if(col.getText().equals(name))
					System.out.print(col.getText() + "\n");
					return true;
				
			}
			
		}
		return false;
	}
	public static boolean isTagDescriptionExistInTable(WebElement el,String description ) {
		WebElement simpleTable = el;
		List<WebElement> rows = simpleTable.findElements(By.tagName("tr"));
		// Print data from each row
		for (WebElement row : rows) {
			List<WebElement> cols = row.findElements(By.tagName("td"));
			
			for (WebElement col : cols) {
				if(col.getText().equals(description))
					System.out.print(col.getText() + "\n");
					return true;
					
				
			}
			
		}
		return false;
	}
	
	
}
