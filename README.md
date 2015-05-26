# dummy-image-creator
One page that will create a dummy image according to query-string values.  

**Usage**:

   
`?size=250x400&type=jpg&bg=ff8800&color=000000`

will create a 250px wide and 400px height jpg image with orange background and black text.
   
`?size=400`

will create a 400px width, 400px height png image with black grey and dark grey text

 
The script will parse the options and if they are not leagal values the defaults are:
  - size: `nothing, the scrit dies`
  - type: `png`
  - bg:   `C7C7C7`
  - color:`8F8F8F`
 
If you are including the `.htaccess` file:

  `?size=250x400&type=jpg&bg=ff8800&color=000000`
  
Same as:

  `/250x400/jpg/ff8800/000000`
  
  
 


