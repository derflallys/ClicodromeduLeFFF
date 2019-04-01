package Verb;

public class Verb1G {
    private String je,tu,il,nous,vous,ils;
    
    public static String Racine(String verb){
    	return verb.substring(0,verb.length()-2);
    	
    }
    //présent de l'indicatif
    public void P(String racine){
    	je=racine +"e";
    	tu=racine+"es";
    	il=racine +"e";
    	nous=racine+"ons";
    	vous=racine+"ez";
    	ils=racine+"ent";	
    }
  //Futur de l'indicatif
    public void F(String racine){
    	je=racine +"erai";
    	tu=racine+"eras";
    	il=racine +"era";
    	nous=racine+"erons";
    	vous=racine+"erez";
    	ils=racine+"eront";	
    }
  //imparfait de l'indicatif
    public void I(String racine){
    	je=racine +"ais";
    	tu=racine+"ais";
    	il=racine +"ait";
    	nous=racine+"ions";
    	vous=racine+"iez";
    	ils=racine+"aient";	
    } 
  //passé simple de l'indicatif
    public void J(String racine){
    	je=racine +"eai";
    	tu=racine+"eas";
    	il=racine +"ea";
    	nous=racine+"eâmes";
    	vous=racine+"eâtes";
    	ils=racine+"èrent";
    }  
  //Conditionnel présent
    public void C(String racine){
    	je=racine +"erais";
    	tu=racine+"erais";
    	il=racine +"erait";
    	nous=racine+"erions";
    	vous=racine+"eriez";
    	ils=racine+"eraient";	
    } 
  //Impératif présent
    public void Y(String racine){
    	tu=racine+"e";
    	nous=racine+"ons";
    	vous=racine+"ez";
    } 
  //Subjonctif présent
    public void S(String racine){
    	je="que je"+racine +"e";
    	tu="que tu"+racine +"es";
    	il="qu'il"+racine +"e";
    	nous="que nous"+racine +"ions";
    	vous="que vous"+racine +"iez";
    	ils="qu'ils"+racine +"ent";
    } 
    //Subjonctif présent
    public void T(String racine){
    	je="que je"+racine +"asse";
    	tu="que tu"+racine +"asses";
    	il="qu'il"+racine +"ât";
    	nous="que nous"+racine +"assions";
    	vous="que vous"+racine +"assiez";
    	ils="qu'ils"+racine +"assent";
    } 
    //participe passé
   public void K(String racine){
	   racine=racine+"é";
   }
   //participe présent
   public void G(String racine){
	   racine=racine+"ant";
   }
}
