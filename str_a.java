import java.util.*;
public class str_a
{
	public static void main(String args[])
	{
		Scanner sc=new Scanner(System.in);
		System.out.println("enter a sentance: ");
		String str=sc.nextLine();
		str=str+" ";
		str=str.toUpperCase();
		int  wcount=0,acount=0;
		String word="";
		for (int i=0;i<str.length();i++)
		{
			if(str.charAt(i)!=' ')
			{
				word=word+str.charAt(i);
			}
			else
			{
				if(word.charAt(0)=='A')
				{
					System.out.println(word);
				}
				word="";
			}
		}
	}
}
