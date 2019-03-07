public class Verbe2 {
    private String radical;
    private String verbe;
    
    public String radical()
    {
        	 this.radical= verbe.substring(0,verbe.length()-2);
         return this.radical;
          
  }  
    public String PI(String personne){   	
    
    		if(personne=="je")
    			radical+="s";
    		if(personne=="tu")
    			radical+="s";
    		if(personne=="il" || personne=="elle" || personne=="on")
    			radical+="t";;
    		if(personne=="nous")
    			radical+="ssons";
    		if(personne=="vous")
    			radical+="ssez";
    		if(personne=="ils" || personne=="elles")
    			 radical+="ssent";
    	
    
    	return radical;  	    	
    }
    public String IMI(String personne){
 		if(personne=="je")
    			radical+="ssais";
    		if(personne=="tu")
    			radical+="ssais";
    		if(personne=="il" || personne=="elle" || personne=="on")
    			radical+="ssait";;
    		if(personne=="nous")
    			radical+="ssions";
    		if(personne=="vous")
    			radical+="ssiez";
    		if(personne=="ils" || personne=="elles")
    			radical+="ssaient";

    	return radical;
    }
    
public String PS(String personne){  
    		if(personne=="je")
    			radical+="is";
    		if(personne=="tu")
    			radical+="is";
    		if(personne=="il" || personne=="elle" || personne=="on")
    			radical+="it";;
    		if(personne=="nous")
    			radical+="îmes";
    		if(personne=="vous")
    			radical+="îtes";
    		if(personne=="ils" || personne=="elles")
    			radical+="irent";
      
    	return radical;
    }

public String FS(String personne){
	if(personne=="je")
			radical+="irai";
		if(personne=="tu")
			radical+="iras";
		if(personne=="il" || personne=="elle" || personne=="on")
			radical+="ira";;
		if(personne=="nous")
			radical+="irons";
		if(personne=="vous")
			radical+="irez";
		if(personne=="ils" || personne=="elles")
			radical+="iront"; 
	return radical;
}

public String Conditionnel(String personne){
		if(personne=="je")
			radical+="irais";
		if(personne=="tu")
			radical+="irais";
		if(personne=="il" || personne=="elle" || personne=="on")
			radical+="irait";;
		if(personne=="nous")
			radical+="irions";
		if(personne=="vous")
			radical+="iriez";
		if(personne=="ils" || personne=="elles")
			radical+="iraient";

	return radical;
}

public String Subjonctif(String personne){
	if(personne=="je")
			radical+="isse";
		if(personne=="tu")
			radical+="isses";
		if(personne=="il" || personne=="elle" || personne=="on")
			radical+="isse";;
		if(personne=="nous")
			radical+="issions";
		if(personne=="vous")
			radical+="issiez";
		if(personne=="ils" || personne=="elles")
			radical+="issent";
	 
	return radical;
}

public String Imperatif_Present(String personne){
	if(personne=="tu")
		radical+="s";
	if(personne=="nous")
		radical+="ssons";
	if(personne=="vous")
		radical+="ssez";
	return radical;
}
public String Imperatif_Passe(String personne){
	if(personne=="tu")
		return "aie"+radical;
	if(personne=="nous")
		return "ayons"+radical;
	if(personne=="vous")
		return "ayez"+radical;

	return null;
}
public String Participe_Present(String personne){
	radical+="ssant";
	return radical;
}
public String Participe_Passe(String personne){
	return radical;
}


}
