import java.util.*;
public class goldbatch
{
	public static void main(String args[])
	{
		Scanner sc=new Scanner (System.in);
		System.out.print("enter 2 number to check goldbatch: ");
		int n=sc.nextInt();
		int m=sc.nextInt();
		if (n<=1 && m<=1)
		{
		System.out.println("not a prime");
		}
		int count=0;
		int s=n+m;
		for (int i=2;i*i<n;i++) 
		{
            		if (n % i == 0)
			{
				count++;
			}
		}
		for (int i=2;i*i<m;i++) 
		{
            		if (m % i == 0)
			{
				count++;
			}
		}
		
		if (count==0)
		{
			System.out.println(n+" prime\n");
			System.out.println(m+" prime\n"); 
			for(int i=2;i+i<s;i++)
			{
				count++;			
			}
				if (count==0)			
				{
					System.out.println(s+" is goldbatch number");		
				}
				else
				{
					System.out.println(s+" is not a goldbatch number");
				}		
		}
		else
		{
			System.out.println(n+" not prime");
			System.out.println(m+" not prime");
		}	
	}
}
