import java.util.*;
public class scount
{
	String str,ori;
	int Vcount,Ccount,Wcount,SPcount=0;
	void get_val()
	{
		Scanner sc=new Scanner(System.in);
		str=sc.nextLine();
		ori=str;
		str=str+" ";
		str=str.toUpperCase();
	}
	void func_val()
	{
		for(int i=0; i<str.length();i++)
		{
			if(str.charAt(i)==' ')
			{
				Wcount++;
			}
			else
			{
				if(str.charAt(i)=='A' || str.charAt(i)=='E' || str.charAt(i)=='I' || str.charAt(i)=='O' ||str.charAt(i)=='U')
				{
					Vcount++;
				}
				else if(str.charAt(i)=='.' || str.charAt(i)=='?' || str.charAt(i)==',' || str.charAt(i)=='!' || str.charAt(i)=='\'' ||str.charAt(i)=='\"')
				{
					SPcount++;
				}
				else
				{
					Ccount++;
				}
			}
		}
	}
	void display_val()
	{
		System.out.println("Original String = "+ori);
		System.out.println("Vowel = "+Vcount);
		System.out.println("Consonent = "+Ccount);
		System.out.println("Punctuation = "+SPcount);
	}
	public static void main(String[] args)
	{
		scount xyz=new scount();
		xyz.get_val();
		xyz.func_val();
		xyz.display_val();
	}
}
