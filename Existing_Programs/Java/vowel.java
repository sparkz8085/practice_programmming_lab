import java.util.*;
public class vowel
{
	public static void main(String args[])
	{
		Scanner sc=new Scanner(System.in);
		int a,b,v=0;
		char chr;
		System.out.println("enter a string : ");
		String st=sc.nextLine();
		b=st.length();
		for (a=0;a<b;a++)
		{
			chr=st.charAt(a);
			if (chr=='a'||chr=='e'||chr=='i'||chr=='o'||chr=='u'||chr=='A'||chr=='E'||chr=='I'||chr=='O'||chr=='U')
			{
				v=v+1;
			}
		}
		System.out.println("the number of vowels in the given string : "+v);
	}
}
