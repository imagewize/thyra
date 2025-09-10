import { chromium } from 'playwright';
import fs from 'fs';

async function compareSites() {
  const browser = await chromium.launch();
  const page = await browser.newPage();
  
  console.log('🌐 Capturing online version...');
  
  // First, capture the online version
  await page.goto('https://clarity-tailwind.preview.uideck.com');
  await page.waitForLoadState('networkidle');
  
  // Take a screenshot
  await page.screenshot({ 
    path: 'online-version.png', 
    fullPage: true 
  });
  
  // Get the page content and structure
  const onlineContent = await page.content();
  
  // Extract key elements and styles
  const onlineStructure = await page.evaluate(() => {
    return {
      title: document.title,
      headerExists: !!document.querySelector('header'),
      heroExists: !!document.querySelector('.hero, [class*="hero"]'),
      navigationLinks: Array.from(document.querySelectorAll('nav a, header a')).map(a => a.textContent.trim()).filter(text => text),
      mainSections: Array.from(document.querySelectorAll('main section, section')).map(section => {
        return {
          classes: section.className,
          headings: Array.from(section.querySelectorAll('h1, h2, h3')).map(h => h.textContent.trim())
        };
      }),
      colorScheme: {
        backgroundColor: getComputedStyle(document.body).backgroundColor,
        primaryColors: Array.from(document.querySelectorAll('[class*="bg-"], [class*="text-"]')).slice(0, 10).map(el => ({
          element: el.tagName,
          classes: el.className.split(' ').filter(cls => cls.includes('bg-') || cls.includes('text-'))
        }))
      }
    };
  });
  
  console.log('🏠 Capturing local version...');
  
  // Now capture the local version
  await page.goto('http://thyra.test');
  await page.waitForLoadState('networkidle');
  
  await page.screenshot({ 
    path: 'local-version.png', 
    fullPage: true 
  });
  
  const localContent = await page.content();
  
  const localStructure = await page.evaluate(() => {
    return {
      title: document.title,
      headerExists: !!document.querySelector('header'),
      heroExists: !!document.querySelector('.hero, [class*="hero"]'),
      navigationLinks: Array.from(document.querySelectorAll('nav a, header a')).map(a => a.textContent.trim()).filter(text => text),
      mainSections: Array.from(document.querySelectorAll('main section, section')).map(section => {
        return {
          classes: section.className,
          headings: Array.from(section.querySelectorAll('h1, h2, h3')).map(h => h.textContent.trim())
        };
      }),
      colorScheme: {
        backgroundColor: getComputedStyle(document.body).backgroundColor,
        primaryColors: Array.from(document.querySelectorAll('[class*="bg-"], [class*="text-"]')).slice(0, 10).map(el => ({
          element: el.tagName,
          classes: el.className.split(' ').filter(cls => cls.includes('bg-') || cls.includes('text-'))
        }))
      }
    };
  });
  
  console.log('\n📊 COMPARISON REPORT');
  console.log('==================');
  
  console.log('\n🌐 ONLINE VERSION (clarity-tailwind.preview.uideck.com)');
  console.log('Title:', onlineStructure.title);
  console.log('Header exists:', onlineStructure.headerExists);
  console.log('Hero section exists:', onlineStructure.heroExists);
  console.log('Navigation links:', onlineStructure.navigationLinks.slice(0, 5));
  console.log('Main sections count:', onlineStructure.mainSections.length);
  console.log('Background color:', onlineStructure.colorScheme.backgroundColor);
  
  console.log('\n🏠 LOCAL VERSION (thyra.test)');
  console.log('Title:', localStructure.title);
  console.log('Header exists:', localStructure.headerExists);
  console.log('Hero section exists:', localStructure.heroExists);
  console.log('Navigation links:', localStructure.navigationLinks.slice(0, 5));
  console.log('Main sections count:', localStructure.mainSections.length);
  console.log('Background color:', localStructure.colorScheme.backgroundColor);
  
  console.log('\n🔍 KEY DIFFERENCES ANALYSIS');
  console.log('=========================');
  
  // Compare navigation
  if (JSON.stringify(onlineStructure.navigationLinks) !== JSON.stringify(localStructure.navigationLinks)) {
    console.log('❌ Navigation differs:');
    console.log('  Online:', onlineStructure.navigationLinks.slice(0, 5));
    console.log('  Local: ', localStructure.navigationLinks.slice(0, 5));
  } else {
    console.log('✅ Navigation is similar');
  }
  
  // Compare sections
  if (onlineStructure.mainSections.length !== localStructure.mainSections.length) {
    console.log('❌ Different number of main sections:');
    console.log('  Online:', onlineStructure.mainSections.length);
    console.log('  Local: ', localStructure.mainSections.length);
  } else {
    console.log('✅ Same number of main sections');
  }
  
  // Compare hero section
  if (onlineStructure.heroExists !== localStructure.heroExists) {
    console.log('❌ Hero section presence differs:');
    console.log('  Online has hero:', onlineStructure.heroExists);
    console.log('  Local has hero: ', localStructure.heroExists);
  } else {
    console.log('✅ Both have similar hero sections');
  }
  
  console.log('\n📸 Screenshots saved:');
  console.log('  - online-version.png (Online version)');
  console.log('  - local-version.png (Local version)');
  
  // Save detailed reports to files
  fs.writeFileSync('online-structure.json', JSON.stringify(onlineStructure, null, 2));
  fs.writeFileSync('local-structure.json', JSON.stringify(localStructure, null, 2));
  fs.writeFileSync('online-content.html', onlineContent);
  fs.writeFileSync('local-content.html', localContent);
  
  console.log('\n📄 Detailed reports saved:');
  console.log('  - online-structure.json');
  console.log('  - local-structure.json');
  console.log('  - online-content.html');
  console.log('  - local-content.html');
  
  await browser.close();
}

compareSites().catch(console.error);
